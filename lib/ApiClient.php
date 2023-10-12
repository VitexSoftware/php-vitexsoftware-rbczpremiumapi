<?php

/**
 *
 *
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2023 Vitex@hippy.cz (G)
 *
 * PHP 7
 */

namespace VitexSoftware\Raiffeisenbank;

/**
 * Description of ApiClient
 *
 * @author vitex
 */
class ApiClient extends \GuzzleHttp\Client
{
    /**
     * ClientID obtained from Developer Portal - when you registered your app with us.
     * @var string
     */
    protected $xIBMClientId = null;

    /**
     * the end IP address of the client application (no server) in IPv4 or IPv6
     * format. If the bank client (your user) uses a browser by which he
     * accesses your server app, we need to know the IP address of his browser.
     * Always provide the closest IP address to the real end-user possible.
     * (optional)
     *
     * @var string
     */
    protected $pSUIPAddress = null;

    /**
     * Use mocking for api calls ?
     * @var boolean
     */
    protected $mockMode = false;

    /**
     * @inheritDoc
     *
     * $config['clientid'] - obtained from Developer Portal - when you registered your app with us.
     * $config['cert'] = ['/path/to/cert.p12','certificat password']
     * $config['clientpubip'] = the closest IP address to the real end-user
     * $config['mocking'] = true to use /rbcz/premium/mock/* endpoints
     *
     * @param array $config
     * @throws \Exception CERT_FILE is not set
     * @throws \Exception CERT_PASS is not set
     */
    public function __construct(array $config = [])
    {
        if (array_key_exists('clientid', $config) === false) {
            $this->xIBMClientId = \Ease\Functions::cfg('XIBMCLIENTID');
        } else {
            $this->xIBMClientId = $config['clientid'];
        }

        if (array_key_exists('cert', $config) === false) {
            $config['cert'] = [\Ease\Functions::cfg('CERT_FILE'), \Ease\Functions::cfg('CERT_PASS')];
            if (empty($config['cert'][0])) {
                throw new \Exception('Certificate (CERT_FILE) not specified');
            }
            if (empty($config['cert'][1])) {
                throw new \Exception('Certificate password (CERT_PASS) not specified');
            }
        }

        if (array_key_exists('debug', $config) === false) {
            $config['debug'] = \Ease\Functions::cfg('API_DEBUG', false);
        }

        if (array_key_exists('clientpubip', $config)) {
            $this->pSUIPAddress = $config['clientpubip'];
        }

        if (array_key_exists('mocking', $config)) {
            $this->mockMode = boolval($config['mocking']);
        }

        parent::__construct($config);
    }

    /**
     * ClientID obtained from Developer Portal
     *
     * @return string
     */
    public function getXIBMClientId()
    {
        return $this->xIBMClientId;
    }

    /**
     * Keep user public IP here
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
     * @return boolean
     */
    public function getMockMode()
    {
        return $this->mockMode;
    }

    /**
     * Obtain Your current Public IP
     *
     * @return string
     */
    public static function getPublicIP()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://httpbin.org/ip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        $ip = json_decode($output, true);
        return $ip['origin'];
    }
}
