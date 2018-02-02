<?php

use Phalcon\Mvc\Url as UrlProvider;


// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    'url',
    function () {
        $config = $this->getConfig();
        $url = new UrlProvider();
        $url->setBaseUri($config->application->baseUri);
        return $url;
    }
);