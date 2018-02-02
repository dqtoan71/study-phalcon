<?php
use services\LoginService;


/** @var object $config */
$di->setShared(
    'login', function () use($config) {
    return new LoginService();
    }
);