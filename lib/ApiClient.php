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
    private $xIBMClientId = null;

    /**
     * @inheritDoc
     * 
     * $config['clientid'] - obtained from Developer Portal - when you registered your app with us.
     * $config['cert'] = ['/path/to/cert.p12','certificat password']
     * 
     * @param array $config 
     * @throws Exception CERT_FILE is not set
     * @throws Exception CERT_PASS is not set
     */
    public function __construct(array $config = [])
    {
        if (array_key_exists('clientid', $config) === false) {
            $this->xIBMClientID = \Ease\Functions::cfg('XIBMCLIENTID');
        }

        if (array_key_exists('cert', $config) === false) {
            $config['cert'] = [\Ease\Functions::cfg('CERT_FILE'), \Ease\Functions::cfg('CERT_PASS')];
            if (empty($config['cert'][0])) {
                throw new Exception('Certificate (CERT_FILE) not specified');
            }
            if (empty($config['cert'][1])) {
                throw new Exception('Certificate password (CERT_PASS) not specified');
            }
        }

        if (array_key_exists('debug', $config) === false) {
            $config['debug'] = \Ease\Functions::cfg('API_DEBUG', false);
        }
        parent::__construct($config);
    }

    /**
     * ClientID obtained from Developer Portal
     * @return string
     */
    public function getXIBMClientId()
    {
        return $this->xIBMClientId;
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
