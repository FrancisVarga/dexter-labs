<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/14/12
 * Time: 2:48 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\JsonRpc\V1\ZeroMq\Service;
class TestZeroMq extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcService
{
    /**
     * @param $params
     */
    public function testEcho($params)
    {
        var_dump($params);
    }
}
