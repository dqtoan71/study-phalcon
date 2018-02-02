<?php

use Phalcon\Mvc\Router;
use Phalcon\Config\Adapter\Toml;


/** @var object $config */

$di->set(
    'router', function() use ($config) {


    $router =  new Router(false);
    $router->removeExtraSlashes(true);

    if(strpos(isset($_SERVER['SERVER_SOFTWARE']), 'Microsoft-IIS')!==false){
        $router->setUriSource(Router::URI_SOURCE_GET_URL);
    }else{
        $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
    }

    $routerConfigFile = APP_PATH.$config->application->routingConfDir;
    $routerConf = (new Toml($routerConfigFile))->router;
    foreach ($routerConf as $key => $conf) {

        $path = [
            'namespace' => $conf->namespace,
            'controller' => $conf->controller,
            'action' => $conf->action,
        ];

        if (isset($conf->other)) {
            foreach ($conf->other as $target => $other) {
                $path[$target] = $other;
            }
        }

        if(isset($conf->method)){
            $router->add($key, $path, $conf->method->toArray());
        }else{
            $router->add($key, $path);
        }

    }

    return $router;
    }
);
