<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/11/29
 * Time: 0:20
 */

use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Redis as BackCached;

/** @var object $config */
$di->set(
    'cache', function ()use($config) {
    $front = new FrontData(
        [
            "lifetime" => $config->cache->lifetime,
        ]
    );
    return new BackCached(
        $front,
        [
            "host"       => $config->cache->host,
            "port"       => $config->cache->port,
            "persistent" => false,
            "index"      => 0,
            "auth"       => $config->cache->auth
        ]
    );
}
);