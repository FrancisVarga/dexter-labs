<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/21/12
 * Time: 5:09 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CouchbaseFlush extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        $cbCli = new \Processus\Lib\Db\CouchbaseClient("bigdata-server:8091", "Administrator", "Administrator", "bigdata");
        $result = $cbCli->flush();
        var_dump($result);
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
