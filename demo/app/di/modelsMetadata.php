<?php

use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;


$di->setShared(
    'modelsMetadata', function () {
    return new MetaDataAdapter();
    }
);