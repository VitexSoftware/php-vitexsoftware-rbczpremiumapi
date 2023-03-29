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
$apiInstance = new \OpenAPI\Client\RaiffeisenBank\GetTransactionListApi(new \GuzzleHttp\Client(['cert' => ['test_cert.p12', 'test12345678'], 'debug' => true]));
$account_number = '1899297002'; // string | Account number for which to get list of transactions in national format without 0 padding.
$currency_code = 'CZK'; // string | Currency code of the account in ISO-4217 standard (e.g. czk, eur, usd)
$from = new \DateTime(); // \DateTime | Defines date (and optionally time) from which transactions will be requested. If no time is specified then 00:00:00.0 will be used. Example values - 2021-08-01 or 2021-08-01T10:00:00.0Z
$to = (new \DateTime())->modify('-1 day'); // \DateTime | Defines date (and optionally time) until which transactions will be requested. If no time is specified then 23:59:59.999 will be used. Example values - 2021-08-02 or 2021-08-02T14:00:00.0Z
$page = 56; // int | Page number to be requested. The first page is 1.
$x_ibm_client_id = 'FbboLD2r1WHDRcuKS4wWUbSRHxlDloWL'; // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = time(); // string | Unique request id provided by consumer application for reference and auditing.
$accept_language = 'cs'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$psu_ip_address = getPublicIP(); // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format. 
//If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser. 
//Always provide the closest IP address to the real end-user possible.


try {
    $result = $apiInstance->getTransactionList($x_ibm_client_id, $x_request_id, $account_number, $currency_code, $from, $to, $psu_ip_address, $page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GetTransactionListApi->getTransactionList: ', $e->getMessage(), PHP_EOL;
}
