<?php

use Phalcon\Http\Response\Cookies;

/** @var object $config */
$di->setShared(
    'cookies', function () use($config) {
    $cookies = new Cookies();
    $cookies->useEncryption(true);
    return $cookies;
    }
);