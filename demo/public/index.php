<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

use Phalcon\Config\Adapter\Toml;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');


//require_once __DIR__ . '/../vendor/autoload.php';

$config = include APP_PATH.'/config/config.php';

// Register an autoloader
include APP_PATH . '/config/loader.php';


// Create a DI
$di = new FactoryDefault();

include APP_PATH . '/config/services.php';

//echo '<pre>';
//print_r($config);
//echo '</pre>';


$application = new \Phalcon\Mvc\Application($di);

try {
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}