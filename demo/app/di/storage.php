<?php
/**
 * Created by IntelliJ IDEA.
 * User: phucanthony
 * Date: 12/6/17
 * Time: 11:40 AM
 */

use services\Storage;

$di->setShared(
    'storage', function () {
    $config = $this->getConfig();
    $storage = new Storage($config->storage);
    return $storage;
}
);