<?php

use Phalcon\Flash\Direct as Flash;
use library\FlashSession;


/** @var object $config */

$di->set(
    'flash', function () {
    return new Flash(
        [
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
        ]
    );
    }
);

$di->set(
    'flashSession', function () {
    return new FlashSession(
        [
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
        ]
    );
    }
);