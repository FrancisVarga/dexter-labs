<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/19/12
 * Time: 11:07 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CouchbaseApiTest extends \Processus\Abstracts\AbstractTask
{

    private $_cbCli;

    public function __construct()
    {
        $this->_cbCli = new \Processus\Lib\Db\CouchbaseClient("127.0.0.1:8091", "Administrator", "Administrator", "default");
    }

    public function run()
    {
        $userRawList = $this->_getKeys();
        $list        = $userRawList['rows'];
        $length      = count($list);
        $keyList     = array();
        for ($i = 0; $i < $length; $i++) {
            $keyList[] = $list[$i]["id"];
        }

        $this->_getMultipleKeys($keyList);
    }

    private function _getMultipleKeys($keys)
    {
        $userData = $this->_cbCli->getMultipleByKey($keys);
        var_dump($userData);
    }

    private function _getKeys()
    {
        return $this->_cbCli->getViewData("portal", "userInfo", array("limit" => 100));
    }

    private function _fetchingViews()
    {
        $viewData = $this->_cbCli->getViewData("portal", "all", array("limit" => 10));
        var_dump($viewData);
    }

    private function _storingRandData()
    {
        $memId = "lol";
        $data  = array(
            "first_name" => "Francis",
            "last_name"  => "Varga",
        );
        $this->_cbCli->insert(md5(mt_rand(0, 3498209340234)), json_encode($data), 0);
        var_dump($this->_cbCli->fetch($memId));
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
