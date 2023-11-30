<?php

namespace VitexSoftware\Raiffeisenbank;

require_once('../vendor/autoload.php');
\Ease\Shared::init(['XIBMCLIENTID' // string | ClientID obtained from Developer Portal - when you registered your app with us.
    ], 'example.env');

$x_request_id = time(); // string | Unique request id provided by consumer application for reference and auditing.
$accept_language = 'cs'; // string | The Accept-Language request HTTP header is used to determine document  language. Supported languages are `cs` and `en`.
$psu_ip_address = ApiClient::getPublicIP(); // string | IP address of a client - the end IP address of the client application (no server) in IPv4 or IPv6 format.
//If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser.
//Always provide the closest IP address to the real end-user possible.

$request_body = new Model\GetStatementsRequest(['account_number' => '1899297002', 'currency' => 'CZK', 'statementLine' => 'MAIN']);
$page = 1; // int | Number of the requested page. Default is 1.
$size = 80; // int | Number of items on the page. Default is 15.

$apiInstance = new PremiumAPI\GetStatementListApi(new ApiClient([
            'clientpubip' => $psu_ip_address,
            'clientid' => \Ease\Shared::cfg('XIBMCLIENTID'),
            'mocking' => true
        ]));
try {
    $result = $apiInstance->getStatements($x_request_id, $request_body, $page, $size);
    print_r($result);
} catch (\Ease\Exception $e) {
    echo 'Exception when calling GetStatementListApi->getStatements: ', $e->getMessage(), PHP_EOL;
}


/**


"/usr/bin/php" "/home/vitex/Projects/VitexSoftware/php-vitexsoftware-rbczpremiumapi/examples/getstatements.php"
*   Trying 82.99.167.1:443...
* Connected to api.rb.cz (82.99.167.1) port 443 (#0)
* ALPN, offering http/1.1
* successfully set certificate verify locations:
*  CAfile: /etc/ssl/certs/ca-certificates.crt
*  CApath: /etc/ssl/certs
* SSL connection using TLSv1.2 / ECDHE-RSA-AES128-GCM-SHA256
* ALPN, server accepted to use http/1.1
* Server certificate:
*  subject: C=CZ; L=Praha; O=Raiffeisenbank a.s.; CN=api.rb.cz
*  start date: May  4 00:00:00 2022 GMT
*  expire date: May  4 23:59:59 2023 GMT
*  subjectAltName: host "api.rb.cz" matched cert's "api.rb.cz"
*  issuer: C=US; O=DigiCert Inc; CN=DigiCert TLS RSA SHA256 2020 CA1
*  SSL certificate verify ok.
> POST /rbcz/premium/mock/accounts/statements?page=1&size=80 HTTP/1.1
Host: api.rb.cz
User-Agent: VitexSoftware/RBCZPremiumAPI/0.1.0/PHP
X-IBM-Client-Id: FbboLD2r1WHDRcuKS4wWUbSRHxlDloWL
X-Request-Id: 1682458803
Accept: application/json
Content-Type: application/json
Content-Length: 41

* upload completely sent off: 41 out of 41 bytes
* old SSL session ID is stale, removing
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Date: Tue, 25 Apr 2023 21:40:46 GMT
< Server: RBCZ
< content-type: application/json; charset=utf-8
< content-length: 1313
< x-ratelimit-limit-second: 5
< x-ratelimit-remaining-second: 4
< x-ratelimit-limit-day: 1000
< x-ratelimit-remaining-day: 999
< ratelimit-limit: 5
< ratelimit-remaining: 4
< ratelimit-reset: 1
< x-kong-upstream-latency: 6
< x-kong-proxy-latency: 6
< via: kong/2.8.1.1-enterprise-edition
< set-cookie: 00cdf75109dda7379df35556e601cac3=bf1c63b65fd3d882f20faa636a31ad8b; path=/; HttpOnly; Secure; SameSite=None
< X-Correlation-Id: 1682458803
<
* Connection #0 to host api.rb.cz left intact
Array
(
    [statements] => Array
        (
            [0] => stdClass Object
                (
                    [statementId] => ab0cb1e8-1926-4c8c-b51e-66f0781f302c
                    [accountId] => 3
                    [statementNumber] => 06/2015
                    [dateFrom] => 2015-06-01
                    [dateTo] => 2015-06-30
                    [statementFormats] => Array
                        (
                            [0] => pdf
                        )

                )

            [1] => stdClass Object
                (
                    [statementId] => f729e637-acf9-4261-8200-8a4e83421759
                    [accountId] => 3
                    [statementNumber] => 07/2015
                    [dateFrom] => 2015-07-01
                    [dateTo] => 2015-07-31
                    [statementFormats] => Array
                        (
                            [0] => xml
                        )

                )

            [2] => stdClass Object
                (
                    [statementId] => 940bc713-919e-4a32-81b8-3be7927081f0
                    [accountId] => 3
                    [statementNumber] => 08/2015
                    [dateFrom] => 2015-08-01
                    [dateTo] => 2015-08-31
                    [statementFormats] => Array
                        (
                            [0] => MT940
                        )

                )

            [3] => stdClass Object
                (
                    [statementId] => 911f1790-1f78-4881-af50-f46054a82698
                    [accountId] => 3
                    [statementNumber] => 09/2015
                    [dateFrom] => 2015-08-01
                    [dateTo] => 2015-08-31
                    [statementFormats] => Array
                        (
                        )

                )

        )

    [page] => 1
    [size] => 10
    [first] => 1
    [last] => 1
    [totalSize] => 4
    [totalPages] => 1
)
Done.

*/
