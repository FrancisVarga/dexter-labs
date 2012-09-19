<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thelittlenerd87
 * Date: 24.08.12
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CBAdvApi extends \Processus\Abstracts\AbstractTask
{
    public function run()
    {
        $this->_preAppendTest();
    }

    private function _preAppendTest()
    {
        $startData = array(
            "name"     => "Francis",
            "lastName" => "Varga"
        );

        $appendData = array(
            "working" => "Crowdpark",
            "city"    => 'Berlin'
        );

        $memId = $this->_getRandMemid("user:dynData");
        echo $memId . PHP_EOL;
        var_dump($this->_getMemCli()->getClient()->set($memId, json_encode($startData) . ",", 0));
        var_dump($this->_getMemCli()->getClient()->append($memId, json_encode($appendData)));
        $json = "[" . $this->_getMemCli()->getClient()->get($memId) . "]";
        var_dump($json);
        var_dump(json_decode($json));
    }

    /**
     * @param $suffix
     *
     * @return string
     */
    private function _getRandMemid($suffix)
    {
        return mt_rand(0, 324879834) . ":" . $suffix;
    }

    /**
     * @var \Application\Core\Lib\Db\MemcachedJson
     */
    private $_memCli;

    private function _getMemCli()
    {
        if (empty($this->_memCli)) {
            $this->_memCli = new \Application\Core\Lib\Db\MemcachedJson("localhost", 11511);
        }

        return $this->_memCli;
    }

    private function _incLogin()
    {
        $manager = new \Application\Manager\Stats\UserStats();
        var_dump($manager->trackLogin(mt_rand(0, 1938498273490)));
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
