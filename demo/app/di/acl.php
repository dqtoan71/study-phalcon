<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 8/27/17
 * Time: 22:44
 */
use Phalcon\Config\Adapter\Toml;

/** @var object $config */
$di->set(
    'acl', function () use($config) {


    $acl = new Toml(APP_PATH.$config->application->routingConfDir);
    $lastUpdateAt = filemtime(APP_PATH.$config->application->routingConfDir);

    $acl = new \services\AclService($acl->acl->toArray(), $lastUpdateAt);
    return $acl;
    }
);