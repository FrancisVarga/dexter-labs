<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thelittlenerd87
 * Date: 28.08.12
 * Time: 14:45
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CouchDbAdapterTest extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        $adapter = new \Processus\Lib\Db\CouchDbClient("casino");
        $uuId    = "user:info:" . mt_rand(0, 34980934809);
        $adapter->insert($uuId, array(
            "firstName" => "Francis",
            "lastName"  => "Varga"
        ));

        var_dump($adapter->fetchOne($uuId));
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
     *
     * @return array
     */
    protected function _getSqlLogParams($rawObject)
    {
        // TODO: Implement _getSqlLogParams() method.
    }
}
