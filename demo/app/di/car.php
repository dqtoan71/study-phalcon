<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/16
 * Time: 3:51
 */


use services\car\CarService;

$di->setShared(
    'car', function () {
    $config = $this->getConfig();
    $car = new CarService($config->car->baseUrl, $config->car->AuthToken);
    return $car;
    }
);