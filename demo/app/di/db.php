<?php


/** @var object $config */
$di->setShared(
    'db', function () {

    $config = $this->getConfig();

    $connection = null;

    switch ($config->database->adapter){
        case 'Sqlsrv':
            $connection = new \Phalcon\Db\Adapter\Pdo\Sqlsrv(
                [
                'host'          => $config->database->host,
                'port'          => $config->database->port,
                'instance'      => $config->database->instance,
                'username'      => $config->database->username,
                'password'      => $config->database->password,
                'db_name'        => $config->database->db_name,
                'pdoType'       => 'sqlsrv',
                'dialectClass'    => '\Phalcon\Db\Dialect\Sqlsrv'
                ]
            );
            break;
        case 'Mysql':
            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
                [
                'host'          => $config->database->host,
                'port'          => $config->database->port,
                'instance'      => $config->database->instance,
                'username'      => $config->database->username,
                'password'      => $config->database->password,
                'db_name'        => $config->database->db_name,
                'pdoType'       => 'mysql',
                'dialectClass'    => '\Phalcon\Db\Dialect\Mysql'
                ]
            );
    }
    $logger = new Phalcon\Logger\Adapter\File(BASE_PATH.'/log/sql.log');
    $formatter = new Phalcon\Logger\Formatter\Line();
    $logger->setFormatter($formatter);

    $eventManager = new \Phalcon\Events\Manager();
    $queryLogger = new \Phalcon\Db\Profiler\QueryLogger($logger);
    $eventManager->attach('db', $queryLogger);
    $connection->setEventsManager($eventManager);
    return $connection;
    }
);