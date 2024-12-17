<?php

namespace VitexSoftware\Raiffeisenbank;

if (file_exists('./vendor/autoload.php')) {
    require_once( './vendor/autoload.php');
    \Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], './examples/example.env');
} else {
    require_once( '../vendor/autoload.php');
    \Ease\Shared::init(['CERT_FILE', 'CERT_PASS', 'XIBMCLIENTID'], '../examples/example.env');
}
