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

if (file_exists('./vendor/autoload.php')) {
    require_once './vendor/autoload.php';
    \Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], './examples/example.env');
} else {
    require_once '../vendor/autoload.php';
    \Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], '../examples/example.env');
}
