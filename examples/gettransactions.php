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

\Ease\Shared::init(['CERT_PASS', 'XIBMCLIENTID', 'ACCOUNT_NUMBER'], $argv[1] ?? '../.env');

$apiInstance = new PremiumAPI\GetTransactionListApi();
$account_number = \Ease\Shared::cfg('ACCOUNT_NUMBER'); // string | Account number for which to get list of transactions in national format without 0 padding.
$currency_code = 'CZK'; // string | Currency code of the account in ISO-4217 standard (e.g. czk, eur, usd)
$from = new \DateTime(); // \DateTime | Defines date (and optionally time) from which transactions will be requested. If no time is specified then 00:00:00.0 will be used. Example values - 2021-08-01 or 2021-08-01T10:00:00.0Z
$to = (new \DateTime())->modify('-1 day'); // \DateTime | Defines date (and optionally time) until which transactions will be requested. If no time is specified then 23:59:59.999 will be used. Example values - 2021-08-02 or 2021-08-02T14:00:00.0Z
$page = 56; // int | Page number to be requested. The first page is 1.

$x_request_id = time(); // string | Unique request id provided by consumer application for reference and auditing.

try {
    $result = $apiInstance->getTransactionList($x_request_id, $account_number, $currency_code, $from, $to, $page);
    print_r($result);
} catch (\Ease\Exception $e) {
    echo 'Exception when calling GetTransactionListApi->getTransactionList: ', $e->getMessage(), \PHP_EOL;
}
