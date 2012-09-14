<?php

$processusCorePath = '../../../../library/Processus/core/';
$applicationPath   = '../../../../application/php/Application/';

require_once($processusCorePath . 'Interfaces/InterfaceBootstrap.php');
require_once($processusCorePath . 'Interfaces/InterfaceApplicationContext.php');
require_once ($processusCorePath . 'ProcessusBootstrap.php');
require_once($applicationPath . 'ApplicationBootstrap.php');

$bootstrap = \Application\ApplicationBootstrap::getInstance();
$bootstrap->init();
$gtw     = new Application\JsonRpc\V1\ZeroMq\Gateway();
$request = new \Application\JsonRpc\V1\ZeroMq\Request();
$socket  = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REP);
$socket->bind("tcp://0.0.0.0:5555");

/* Loop receiving and echoing back */
while ($message = $socket->recv()) {

    $request->loadJson($message);
    $gtw->getServer()->setRequest($request);
    $bootstrap->setGateway($gtw);
    $gtw->run();

}