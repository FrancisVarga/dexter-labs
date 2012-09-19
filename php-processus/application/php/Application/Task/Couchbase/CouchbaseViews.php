<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thelittlenerd87
 * Date: 07.08.12
 * Time: 14:59
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CouchbaseViews extends \Processus\Abstracts\AbstractTask
{
    public function run()
    {
        var_dump($this->_fetchKeyTest());
    }

    protected function _fetchKeyTest()
    {
        $adapter = new \Application\Utils\CBAdapter();
        return $adapter->setView("all")
            ->setBucketName("gec")
            ->setDesign("portal")
            ->fetchAll(array(
                "limit"      => 10,
                "key"        => '1345199343162013504',
            )
        );

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
