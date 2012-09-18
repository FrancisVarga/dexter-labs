<?php

$processusCorePath = '../../../../library/Processus/core/';
$applicationPath   = '../../../../application/php/Application/';

require_once($processusCorePath . 'Interfaces/InterfaceBootstrap.php');
require_once($processusCorePath . 'Interfaces/InterfaceApplicationContext.php');
require_once ($processusCorePath . 'ProcessusBootstrap.php');
require_once($applicationPath . 'ApplicationBootstrap.php');

$socket = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_PULL);
$socket->bind("tcp://0.0.0.0:5555");

gc_enable();

/* Loop receiving and echoing back */
while (TRUE) {

    try {

        $message = $socket->recv(\ZMQ::MODE_NOBLOCK);

        /** @var $bootstrap \Application\ApplicationBootstrap */
        $bootstrap = \Application\ApplicationBootstrap::getInstance();
        $bootstrap->init();

        $request = new \Application\JsonRpc\V1\ZeroMq\Request();
        $gtw     = new \Application\JsonRpc\V1\ZeroMq\Gateway();

        /** adding gtw to the bootstrap */
        $bootstrap->setGateway($gtw);

        $request->loadJson($message);
        $request->init();

        $gtw->setRequest($request);
        $gtw->getServer()->setAutoEmitResponse(FALSE);
        $gtw->run();

        unset($request);
        unset($gtw);
        unset($bootstrap);
        unset($message);

    } catch (\Exception $error) {
        $logManager = new \Application\Manager\LoggingManager();
        //$logManager->logDump($error, "logging:error:");
        var_dump($error);
    }
    //usleep(500);
}