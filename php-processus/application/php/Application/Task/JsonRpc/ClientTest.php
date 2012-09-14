<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/14/12
 * Time: 3:02 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\JsonRpc;
class ClientTest extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        $client = new \Processus\Lib\JsonRpc\Client();
        $client->setGateway("http://localhost/dexter-labs/php-processus/htdocs/api/v1/app/index.php");

        $rpcData = new \Processus\Lib\JsonRpc\JsonRpcDataVo();
        $rpcData->setMethod("App.User.echoPing")
            ->setParams(array("Hallo hier ist bullshit zu sehen!"))
            ->setRpcId(1);

        var_export($client->sendRpc($rpcData));
    }

    /**
     * @return string
     */
    protected function _getLogTable()
    {
        // TODO: Implement _getLogTable() method.
    }

    /**
     * @param $rawObject
     * @return array
     */
    protected function _getSqlLogParams($rawObject)
    {
        // TODO: Implement _getSqlLogParams() method.
    }
}
