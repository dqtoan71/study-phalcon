<?php

use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * Start the session the first time some component request the session service
 */
$di->setShared(
    'session', function () use($config) {
    $timeout = $config->session->timeout??604800;
    ini_set('session.gc_maxlifetime', $timeout);
    session_set_cookie_params($timeout);

    $session = new SessionAdapter();
    $session->start();

    return $session;
    }
);