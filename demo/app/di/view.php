<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

/**
 * Setting up the view component
 */
$di->setShared(
    'view', function ()use ($di) {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($di);
    $view->setViewsDir(APP_PATH.$config->application->viewsDir);

    $view->registerEngines(
        [
            '.volt' => function ($view, $di) {
                $config = $this->getConfig();

                $volt = new VoltEngine($view, $di);


                $volt->setOptions(
                    [
                        'compiledPath' => APP_PATH.$config->application->cacheDir,
                        'compiledSeparator' => '_'
                    ]
                );

                return $volt;
            },
            '.phtml' => PhpEngine::class

        ]
    );

    return $view;
}
);