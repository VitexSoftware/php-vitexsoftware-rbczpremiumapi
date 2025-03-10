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
/**
 * Get today's transactions list.
 */
\Ease\Shared::init(['CERT_PASS', 'XIBMCLIENTID', 'ACCOUNT_NUMBER'], $argv[1] ?? '../.env');
ApiClient::checkCertificatePresence(\Ease\Shared::cfg('CERT_FILE'));
$engine = new Statementor(\Ease\Shared::cfg('ACCOUNT_NUMBER'));
$engine->setScope(\Ease\Shared::cfg('STATEMENT_IMPORT_SCOPE', 'last_month'));

$saveTo = \Ease\Shared::cfg('STATEMENT_SAVE_DIR', './');

if (file_exists($saveTo) === false) {
    mkdir($saveTo, 0o777, true);
}

$engine->download($saveTo, $engine->getStatements(), 'xml');
