<?php

/** @var object $config */

use services\usappy\UsappyService;

$di->setShared(
    'usappy', function () {
    $config = $this->getConfig();
    $usappy = new UsappyService($config->usappy);
    return $usappy;
    }
);