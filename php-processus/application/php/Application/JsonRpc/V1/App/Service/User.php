<?php

namespace Application\JsonRpc\V1\App\Service;

class User extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcService
{
    /**
     * @param $params
     * @return mixed
     */
    public function echoPing($params)
    {
        return TRUE;
    }
}


?>