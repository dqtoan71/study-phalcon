<?php
use Phalcon\Config\Adapter\Toml;

require_once __DIR__.'/../../vendor/autoload.php';

$config = new Toml(__DIR__."/config.toml");
if(file_exists(__DIR__."/config.local.toml")){
    $localConfig = new Toml(__DIR__."/config.local.toml");
    $config->merge($localConfig);
}

if( ($__DEV__??false) && file_exists(__DIR__."/config.dev.toml") ){
    $configDev = new Toml(__DIR__."/config.dev.toml");
    $config->merge($configDev);

    if(file_exists(__DIR__."/config.dev.local.toml")){
        $configDevLocal = new Toml(__DIR__."/config.dev.local.toml");
        $config->merge($configDevLocal);
    }
}

//echo '<pre>';
//print_r($config);
//echo '</pre>';

return $config;