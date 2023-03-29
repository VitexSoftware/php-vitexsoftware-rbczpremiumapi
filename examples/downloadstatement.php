<?php

namespace AbraFlexi\RaiffeisenBank;

require_once( '../vendor/autoload.php');

function getPublicIP()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://httpbin.org/ip");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    $ip = json_decode($output, true);
    return $ip['origin'];
}
$apiInstance = new \OpenAPI\Client\RaiffeisenBank\DownloadStatementApi(new \GuzzleHttp\Client(['cert' => ['test_cert.p12', 'test12345678'], 'debug' => true]));
$x_ibm_client_id = 'FbboLD2r1WHDRcuKS4wWUbSRHxlDloWL'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = time(); // string | Unique request id provided by consumer application for reference and auditing.
$accept_language = 'cs'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$request_body = new \OpenAPI\Client\Model\DownloadStatementRequest(['account_number'=>'1899297002','currency'=>'CZK','statementFormat'=>'xml','statementId'=>'f729e637-acf9-4261-8200-8a4e83421759']); 
$psu_ip_address = getPublicIP(); // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. 
//If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. 
//Always provide the closest IP address to the real end-user possible.

try {
    $result = $apiInstance->downloadStatement($x_ibm_client_id, $x_request_id, $accept_language, $request_body, $psu_ip_address);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DownloadStatementApi->downloadStatement: ', $e->getMessage(), PHP_EOL;
}
