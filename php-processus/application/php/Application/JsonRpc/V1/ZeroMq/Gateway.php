<?php

namespace Application\JsonRpc\V1\ZeroMq;
class Gateway extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcGateway
{

    protected $_config = array(
        'enabled'      => TRUE,
        'namespace'    => __NAMESPACE__,
        'validDomains' => array(
            'ZeroMq',
        )
    );

}

?>