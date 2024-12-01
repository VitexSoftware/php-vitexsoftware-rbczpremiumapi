<?php

/**
 * RaiffeisenBank - Statements downloader.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.com>
 * @copyright  (C) 2023 Spoje.Net
 */

namespace VitexSoftware\Raiffeisenbank;

require_once('../vendor/autoload.php');
/**
 * Get today's transactions list
 */
\Ease\Shared::init(['CERT_PASS', 'XIBMCLIENTID', 'ACCOUNT_NUMBER'], isset($argv[1]) ? $argv[1] : '../.env');
ApiClient::checkCertificatePresence(\Ease\Shared::cfg('CERT_FILE'));
$engine = new Statementor(\Ease\Shared::cfg('ACCOUNT_NUMBER'));
$engine->setScope(\Ease\Shared::cfg('STATEMENT_IMPORT_SCOPE', 'last_month'));

$saveTo = \Ease\Shared::cfg('STATEMENT_SAVE_DIR', './');

if (file_exists($saveTo) === false) {
    mkdir($saveTo, 0777, true);
}

$engine->download($saveTo, $engine->getStatements(), 'xml');
