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
     * {@inheritDoc}
     *
     * $config['clientid'] - obtained from Developer Portal - when you registered your app with us.
     * $config['cert'] = ['/path/to/cert.p12','certificat password']
     * $config['clientpubip'] = the closest IP address to the real end-user
     * $config['mocking'] = true to use /rbcz/premium/mock/* endpoints
     *
     * @throws \Exception CERT_FILE is not set
     * @throws \Exception CERT_PASS is not set
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

        if (\array_key_exists('debug', $config) === false) {
            $config['debug'] = \Ease\Shared::cfg('API_DEBUG', false);
        }

        if (\array_key_exists('clientpubip', $config)) {
            $this->pSUIPAddress = $config['clientpubip'];
        }

        if (\array_key_exists('mocking', $config)) {
            $this->mockMode = (bool) $config['mocking'];
        }

        $limitStore = new RateLimit\JsonRateLimitStore(sys_get_temp_dir().'/rbczpremiumapi_rates.json');

        $this->rateLimiter = new RateLimiter($limitStore);

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
     * @throws Exception - Certificate file not found
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

    public static function checkCertificate($certFile, $password): bool
    {
        return self::checkCertificatePresence($certFile) && self::checkCertificatePassword($certFile, $password);
    }

    public static function checkCertificatePassword(string $certFile, string $password): bool
    {
        $certContent = file_get_contents($certFile);

        if (openssl_pkcs12_read($certContent, $certs, $password) === false) {
            fwrite(\STDERR, 'Cannot read PKCS12 certificate file: '.$certFile.\PHP_EOL);

            exit(1);
        }

        return true;
    }

    /**
     * Request Identifier.
     *
     * @todo Obtain using RateLimiter
     *
     * @deprecated since version 0.1 - Do not use in production Environment!
     *
     * @return string
     */
    public static function getxRequestId()
    {
        return substr(self::sourceString().'#'.time(), -59);
    }

    /**
     * Send an HTTP request.
     *
     * @param array $options Request options to apply to the given
     *                       request and to the transfer. See \GuzzleHttp\RequestOptions.
     *
     * @throws GuzzleException
     * @throws RateLimitExceededException
     */
    public function send(\Psr\Http\Message\RequestInterface $request, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        $this->rateLimiter->checkBeforeRequest($this->xIBMClientId);

        $response = parent::send($request, $options);

        $statusCode = $response->getStatusCode();
        $responseHeaders = $response->getHeaders();

        if (isset($responseHeaders['x-ratelimit-remaining-second'])) {
            $remainingSecond = (int) $responseHeaders['x-ratelimit-remaining-second'][0];
            $remainingDay = (int) $responseHeaders['x-ratelimit-remaining-day'][0];

            $timestamp = time();

            $this->rateLimiter->handleRateLimits($this->xIBMClientId, $remainingSecond, $remainingDay, $timestamp);
        }

        if ($statusCode === 429) { // 429 Too Many Requests
            if ($this->rateLimiter->isWaitMode()) {
                $this->rateLimiter->checkBeforeRequest($this->xIBMClientId);
                $response = parent::send($request, $options);
            } else {
                throw new RateLimitExceededException('Rate limit exceeded (HTTP 429)');
            }
        }

        return $response;
    }
}
