<?php
namespace VitexSoftware\Raiffeisenbank;

require_once( '/var/lib/composer/php-vitexsoftware-rbczpremiumapi-dev/autoload.php');
\Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], '/var/lib/composer/php-vitexsoftware-rbczpremiumapi-dev/test.env');

$certFile = \Ease\Functions::cfg('CERT_FILE');
if ((file_exists($certFile) === false) || (is_readable($certFile) === false)) {
    fwrite(STDERR, 'Cannot read specified certificate file: ' . $certFile . PHP_EOL);
    exit;
}

