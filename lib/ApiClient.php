<?php

declare(strict_types=1);

/**
 * This file is part of the MultiFlexi package
 *
 * https://github.com/VitexSoftware/php-vitexsoftware-rbczpremiumapi
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VitexSoftware\Raiffeisenbank;

use VitexSoftware\Raiffeisenbank\RateLimit\RateLimiter;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitExceededException;

/**
 * Description of ApiClient.
 *
 * @author vitex
 */
class ApiClient extends \GuzzleHttp\Client
{
    /**
     * ClientID obtained from Developer Portal - when you registered your app with us.
     */
    protected string $xIBMClientId = '';

    /**
     * the end IP address of the client application (no server) in IPv4 or IPv6
     * format. If the bank client (your user) uses a browser by which he
     * accesses your server app, we need to know the IP address of his browser.
     * Always provide the closest IP address to the real end-user possible.
     * (optional).
     */
    protected string $pSUIPAddress = '';

    /**
     * Use mocking for api calls ?
     */
    protected bool $mockMode = false;
    private RateLimiter $rateLimiter;

    /**
     * Path to the certificate file used for mTLS authentication.
     */
    private string $certFilePath = '';

    /**
     * Cached certificate fingerprint for rate limiting.
     */
    private ?string $certFingerprint = null;

    /**
     * Initialize the API client with configuration, certificate validation, and a rate limiter.
     *
     * Accepted $config keys:
     * - 'clientid': client ID from the Developer Portal.
     * - 'cert': array with [pathToP12, password]; when omitted, CERT_FILE and CERT_PASS configuration values are used.
     * - 'clientpubip': client public IP (nearest to the end user).
     * - 'mocking': bool to enable mock endpoints.
     * - 'debug': debug flag.
     *
     * @param array $config client configuration
     *                      - 'clientid': client ID from Developer Portal
     *                      - 'cert': [path, password]
     *                      - 'clientpubip': client public IP
     *                      - 'mocking': bool
     *                      - 'debug': bool
     *                      - 'rate_limit_store': RateLimitStoreInterface instance (optional)
     *                      - 'rate_limit_wait': bool - wait when limited (default true)
     *
     * @throws \Exception if certificate file path (CERT_FILE) is not provided
     * @throws \Exception if certificate password (CERT_PASS) is not provided
     */
    public function __construct(array $config = [])
    {
        if (\array_key_exists('clientid', $config) === false) {
            $this->xIBMClientId = \Ease\Shared::cfg('XIBMCLIENTID');
        } else {
            $this->xIBMClientId = $config['clientid'];
        }

        if (\array_key_exists('cert', $config) === false) {
            $config['cert'] = [\Ease\Shared::cfg('CERT_FILE'), \Ease\Shared::cfg('CERT_PASS')];

            if (empty($config['cert'][0])) {
                throw new \Exception('Certificate (CERT_FILE) not specified');
            }

            if (empty($config['cert'][1])) {
                throw new \Exception('Certificate password (CERT_PASS) not specified');
            }
        }

        $this->certFilePath = $config['cert'][0];

        if (\array_key_exists('debug', $config) === false) {
            $config['debug'] = \Ease\Shared::cfg('API_DEBUG', false);
        }

        if (\array_key_exists('clientpubip', $config)) {
            $this->pSUIPAddress = $config['clientpubip'];
        }

        if (\array_key_exists('mocking', $config)) {
            $this->mockMode = (bool) $config['mocking'];
        }

        if (isset($config['rate_limit_store'])) {
            $limitStore = $config['rate_limit_store'];
        } else {
            $path = $config['rate_limit_path'] ?? sys_get_temp_dir().'/rbczpremiumapi_rates.json';
            $limitStore = new RateLimit\JsonRateLimitStore($path);
        }

        $waitMode = $config['rate_limit_wait'] ?? true;
        $this->rateLimiter = new RateLimiter($limitStore, $waitMode);

        parent::__construct($config);
    }

    /**
     * ClientID obtained from Developer Portal.
     *
     * @return string
     */
    public function getXIBMClientId()
    {
        return $this->xIBMClientId;
    }

    /**
     * Keep user public IP here.
     *
     * @return string
     */
    public function getpSUIPAddress()
    {
        return $this->pSUIPAddress;
    }

    /**
     * Use mocking uri for api calls ?
     *
     * @return bool
     */
    public function getMockMode()
    {
        return $this->mockMode;
    }

    /**
     * Obtain Your current Public IP.
     *
     * @deprecated since version 0.1 - Do not use in production Environment!
     *
     * @return string
     */
    public static function getPublicIP()
    {
        $curl = curl_init();
        curl_setopt($curl, \CURLOPT_URL, 'http://httpbin.org/ip');
        curl_setopt($curl, \CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        $ip = json_decode($output, true);

        return $ip['origin'];
    }

    /**
     * Source Identifier.
     *
     * @deprecated since version 0.1 - Do not use in production Environment!
     *
     * @return string
     */
    public static function sourceString()
    {
        return substr(__FILE__.'@'.gethostname(), -50);
    }

    /**
     * Try to check certificate readibilty.
     *
     * @param string $certFile path to certificate
     * @param bool   $die      throw exception or return false ?
     *
     * @throws \Exception - Certificate file not found
     *
     * @return bool certificate file
     */
    public static function checkCertificatePresence(string $certFile, bool $die = false): bool
    {
        $found = false;

        if ((file_exists($certFile) === false) || (is_readable($certFile) === false)) {
            $errMsg = 'Cannot read specified certificate file: '.$certFile;
            fwrite(\STDERR, $errMsg.\PHP_EOL);

            if ($die) {
                throw new \Exception($errMsg);
            }
        } else {
            $found = true;
        }

        return $found;
    }

    public static function checkCertificate(string $certFile, string $password): bool
    {
        return self::checkCertificatePresence($certFile) && self::checkCertificatePassword($certFile, $password);
    }

    public static function checkCertificatePassword(string $certFile, string $password): bool
    {
        $certContent = file_get_contents($certFile);

        if (openssl_pkcs12_read($certContent, $certs, $password) === false) {
            fwrite(\STDERR, 'Cannot read PKCS12 certificate file: '.$certFile.\PHP_EOL);

            throw new \Exception('Cannot read PKCS12 certificate file: '.$certFile);
        }

        return true;
    }

    /**
     * Produce a short request identifier used for diagnostics and testing.
     *
     * @deprecated since version 0.1 — Do not use in production environments.
     *
     * @return string the generated request identifier composed from a source token and the current timestamp, truncated to at most 59 characters
     */
    public static function getxRequestId()
    {
        return substr(self::sourceString().'#'.time(), -59);
    }

    /**
     * Get the decimal serial number of the certificate used for mTLS.
     *
     * This serial number is used as the client identifier for rate limiting,
     * as rate limits in the API are tied to the certificate, not to X-IBM-Client-Id.
     *
     * @throws \Exception if unable to read or parse the certificate
     *
     * @return string Decimal serial number of the certificate
     */
    public function getCertificateSerialNumber(): string
    {
        if ($this->certFingerprint !== null) {
            return $this->certFingerprint;
        }

        if (empty($this->certFilePath)) {
            throw new \Exception('Certificate file path not set');
        }

        $certContent = file_get_contents($this->certFilePath);

        if ($certContent === false) {
            throw new \Exception('Unable to read certificate file: '.$this->certFilePath);
        }

        $certs = [];

        if (openssl_pkcs12_read($certContent, $certs, $this->getConfig()['cert'][1]) === false) {
            throw new \Exception('Unable to parse PKCS12 certificate: '.openssl_error_string());
        }

        if (!isset($certs['cert'])) {
            throw new \Exception('Certificate not found in PKCS12 file');
        }

        $certResource = openssl_x509_read($certs['cert']);

        if ($certResource === false) {
            throw new \Exception('Unable to read X509 certificate: '.openssl_error_string());
        }

        $certData = openssl_x509_parse($certResource);

        if ($certData === false || !isset($certData['serialNumber'])) {
            throw new \Exception('Unable to parse certificate data: '.openssl_error_string());
        }

        // serialNumber from openssl_x509_parse is already in decimal format
        $this->certFingerprint = $certData['serialNumber'];

        return $this->certFingerprint;
    }

    /**
     * Send an HTTP request while enforcing and updating client rate limits.
     *
     * Rate limits are enforced per certificate (not per X-IBM-Client-Id).
     * The certificate serial number is used as the client identifier.
     *
     * @param \Psr\Http\Message\RequestInterface $request the HTTP request to send
     * @param array                              $options Request options to apply to the transfer. See \GuzzleHttp\RequestOptions.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws RateLimitExceededException            if the client is rate limited and wait mode is disabled
     *
     * @return \Psr\Http\Message\ResponseInterface the HTTP response
     */
    public function send(\Psr\Http\Message\RequestInterface $request, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        $certFingerprint = $this->getCertificateSerialNumber();

        $this->rateLimiter->checkBeforeRequest($certFingerprint);

        $response = parent::send($request, $options);

        $this->updateRateLimitsFromResponse($response);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 429) { // 429 Too Many Requests
            if ($this->rateLimiter->isWaitMode()) {
                $this->rateLimiter->checkBeforeRequest($certFingerprint);
                $response = parent::send($request, $options);

                $this->updateRateLimitsFromResponse($response);

                $statusCode = $response->getStatusCode();
            } else {
                throw new RateLimitExceededException('Rate limit exceeded (HTTP 429)');
            }
        }

        return $response;
    }

    /**
     * Update rate limits from API response headers.
     *
     * Uses the certificate serial number as the client identifier for storing rate limits.
     *
     * @param \Psr\Http\Message\ResponseInterface $response the HTTP response containing rate limit headers
     */
    private function updateRateLimitsFromResponse(\Psr\Http\Message\ResponseInterface $response): void
    {
        if ($response->hasHeader('x-ratelimit-remaining-second') && $response->hasHeader('x-ratelimit-remaining-day')) {
            $remainingSecond = (int) $response->getHeaderLine('x-ratelimit-remaining-second');
            $remainingDay = (int) $response->getHeaderLine('x-ratelimit-remaining-day');
            $timestamp = time();
            $certFingerprint = $this->getCertificateSerialNumber();
            $this->rateLimiter->handleRateLimits($certFingerprint, $remainingSecond, $remainingDay, $timestamp);
        }
    }
}
