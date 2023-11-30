<?php

namespace VitexSoftware\Raiffeisenbank;

require_once('../vendor/autoload.php');

\Ease\Shared::init(['CERT_FILE','CERT_PASS','XIBMCLIENTID'],__DIR__.'/example.env');

$apiInstance = new PremiumAPI\GetAccountsApi(new ApiClient());
$x_ibm_client_id = \Ease\Shared::cfg('XIBMCLIENTID'); // string | ClientID obtained from Developer Portal - when you registered your app with us.
$x_request_id = time(); // string | Unique request id provided by consumer application for reference and auditing.
$accept_language = 'cs'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$psu_ip_address = ApiClient::getPublicIP(); // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format.
//If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser.
//Always provide the closest IP address to the real end-user possible.

$page = 56; // int | Number of the requested page. Default is 1.
$size = 56; // int | Number of items on the page. Default is 15.

try {
    $result = $apiInstance->getAccounts($x_request_id, $page, $size);
    print_r($result);
} catch (\Ease\Exception $e) {
    echo 'Exception when calling GetAccountsApi->getAccounts: ', $e->getMessage(), PHP_EOL;
}
