<?php

namespace VitexSoftware\Raiffeisenbank;

if (file_exists('./vendor/autoload.php')) {
    require_once( './vendor/autoload.php');
    \Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], './test/test.env');
} else {
    require_once( '../vendor/autoload.php');
    \Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], '../test/test.env');
}

$certFile = \Ease\Functions::cfg('CERT_FILE');
if ((file_exists($certFile) === false) || (is_readable($certFile) === false)) {
    fwrite(STDERR, 'Cannot read specified certificate file: ' . $certFile . PHP_EOL);
    exit;
}
