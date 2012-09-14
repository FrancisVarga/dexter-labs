#!/usr/local/bin/php -d memory_limit=536870912 -f

<?php
$processusCorePath = __DIR__ . '/../library/Processus/core/';
$applicationPath   = __DIR__ . '/../application/php/Application/';

require_once($processusCorePath . 'Interfaces/InterfaceBootstrap.php');
require_once($processusCorePath . 'ProcessusBootstrap.php');
require_once($applicationPath . 'ApplicationBootstrap.php');

\Application\ApplicationBootstrap::getInstance()->init("TASK");
\Processus\Task\Runner::run();
