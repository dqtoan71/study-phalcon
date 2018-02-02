<?php


use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;


/** @var object $config */
$di->set(
    "dispatcher",
    function () {
        // Create an events manager
        $eventsManager = new EventsManager();

        $eventsManager->attach(
            "dispatch:beforeExecuteRoute",
            function($event, Dispatcher $dispatcher){

                $namespace = $dispatcher->getNamespaceName();



                $role = "Guest";



                $controller = $dispatcher->getControllerName();
                $action     = $dispatcher->getActionName();


                $isAllowed = true;


                if(!$isAllowed  && $namespace==='controllers\api'){
                    $dispatcher->setNamespaceName('controllers');
                    $dispatcher->setControllerName('error');
                    $dispatcher->setActionName('error');
                    $dispatcher->setParams(
                        [
                            "code"       => 401,
                            "message"    => 'oauth error',
                            'isApi'      => true
                        ]
                    );
                    $dispatcher->dispatch();
                    return false;
                }


                if(!$isAllowed){
                    $dispatcher->setNamespaceName('controllers');
                    $dispatcher->setControllerName('login');
                    $dispatcher->setActionName('index');
                    $dispatcher->dispatch();
                    return false;
                }
            }
        );


        // Attach a listener
        $eventsManager->attach(
            "dispatch:beforeException",
            function ($event,Phalcon\Mvc\Dispatcher $dispatcher,\Throwable $exception) {

                if($exception instanceof \Phalcon\Mvc\Dispatcher\Exception){
                    switch ($exception->getCode()){
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                            $dispatcher->forward(
                                [
                                    "namespace"  => 'controllers',
                                    "controller" => "error",
                                    "action"     => "error",
                                    "params"     => [
                                        "code"       => 404,
                                        "message"    => 'not found error'
                                    ]
                                ]
                            );
                            return false;
                    }
                }else if ($exception instanceof \library\exceptions\ErrorResponseException) {
                    $dispatcher->forward(
                        [
                            "namespace"  => 'controllers',
                            "controller" => "error",
                            "action"     => "errorException",
                            "params"     => [$exception]
                        ]
                    );
                    return false;
                }
            }
        );

        $dispatcher = new Dispatcher();

        // Assign the events manager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);