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

require_once '../vendor/autoload.php';

// \Ease\Shared::init(['CERT_FILE','CERT_PASS','XIBMCLIENTID'], __DIR__ . '/example.env');
\Ease\Shared::init(['CERT_PASS', 'XIBMCLIENTID', 'ACCOUNT_NUMBER'], $argv[1] ?? '../.env');

$apiInstance = new PremiumAPI\GetAccountsApi();
$x_request_id = time(); // string | Unique request id provided by consumer application for reference and auditing.
// If the bank client (your user) uses a browser by which he accesses your server app, we need to know the IP address of his browser.
// Always provide the closest IP address to the real end-user possible.

$page = 56; // int | Number of the requested page. Default is 1.
$size = 56; // int | Number of items on the page. Default is 15.

try {
    $result = $apiInstance->getAccounts($x_request_id, $page, $size);
    print_r($result);
} catch (\Ease\Exception $e) {
    echo 'Exception when calling GetAccountsApi->getAccounts: ', $e->getMessage(), \PHP_EOL;
}
