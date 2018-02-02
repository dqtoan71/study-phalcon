<?php
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Config\Adapter\Ini as ConfigIni;
$config_lang = new ConfigIni(__DIR__.'/../config/lang.ini');
$lang = $config_lang;
$logger = new FileAdapter(__DIR__.'/../../log/error.log');
$formatter = new Phalcon\Logger\Formatter\Line();
$logger->setFormatter($formatter);
$logger->begin();
$logger->commit();
