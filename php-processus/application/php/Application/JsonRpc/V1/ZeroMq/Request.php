<?php

namespace Application\JsonRpc\V1\ZeroMq;
class Request extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcRequest
{
    public function __construct()
    {

    }

    /**
     * @return Request
     */
    public function init()
    {
        list ($this->_domain, $this->_class, $this->_method) = explode('.',
            parent::getMethod());

        return $this;
    }
}

?>