<?php

$loader = new \Phalcon\Loader();
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        APP_PATH.$config->application->controllersDir,
        APP_PATH.$config->application->modelsDir,
        APP_PATH.$config->application->servicesDir,
        APP_PATH.$config->application->testsDir,
        APP_PATH.$config->application->pluginsDir,
        APP_PATH.$config->application->repositoriesDir,
        APP_PATH.$config->application->libraryDir,
        APP_PATH.$config->application->phalconDir,
        APP_PATH.$config->application->validationDir
    ]
)->registerNamespaces(
    [
        'controllers'   => APP_PATH.$config->application->controllersDir,
        'models'        => APP_PATH.$config->application->modelsDir,
        'plugins'       => APP_PATH.$config->application->pluginsDir,
        'services'      => APP_PATH.$config->application->servicesDir,
        'repositories'  => APP_PATH.$config->application->repositoriesDir,
        'library'       => APP_PATH.$config->application->libraryDir,
        'validation'    => APP_PATH.$config->application->validationDir,
        'Phalcon'       => APP_PATH.$config->application->phalconDir
    ]
)->register();