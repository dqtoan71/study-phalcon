<?php
/**
* Shared configuration service
*/

use Phalcon\Crypt;

/** @var object $config */
$di->setShared(
    'crypt', function () use($config) {
    $crypt = new Crypt();
    $crypt->setKey($config->crypt->key);
    return $crypt;
    }
);