<?php
/**
* Shared configuration service
*/

/** @var object $config */
$di->setShared(
    'config', function () use($config) {
    return $config;
    }
);