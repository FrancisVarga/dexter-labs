<?php

namespace Application\JsonRpc\V1\ZeroMq;
class Server extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcServer
{
    protected $_config = array(
        'namespace'    => __NAMESPACE__,
        'validClasses' => array(
            'TestZeroMq',
            'LoggingData',
        )
    );
}


?>