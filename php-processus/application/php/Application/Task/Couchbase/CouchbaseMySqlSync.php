<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/20/12
 * Time: 6:37 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CouchbaseMySqlSync extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        $sqlStmt  = "SHOW TABLES";
        $allTabes = $this->_getDbHandler()->fetchAll($sqlStmt);
        $this->_fetchAllDataFromTable("tracking_capabilities");
//        foreach ($allTabes as $key => $value) {
//            $tableName = array_values($value);
//            $this->_fetchAllDataFromTable($tableName[0]);
//        }

    }

    private function _fetchAllDataFromTable($tableName)
    {
        $sqlStmt = "SELECT count(*) FROM " . $tableName;
        $maxRows = $this->_getDbHandler()->fetchOne($sqlStmt);
        if ($maxRows == 0) {
            return;
        }

        $maxResult = 1000;
        $floatPage = $maxRows / $maxResult;
        $pages     = 1;
        $pages     = $pages + round($floatPage, 0, PHP_ROUND_HALF_ODD);

        var_dump($tableName . " // " . $pages . " // " . $maxRows);

        for ($i = 0; $i <= $pages; $i++) {
            $offset   = $i * $maxResult;
            $sqlStmt  = "SELECT * FROM $tableName LIMIT $offset, $maxResult";
            $dbResult = $this->_getDbHandler()->fetchAll($sqlStmt);
            if ($dbResult) {
                $this->_saveInCouchbase($dbResult, $tableName);
            } else {
                return;
            }
        }
    }

    private function _saveInCouchbase($data, $tableName)
    {
        foreach ($data as $value) {
            if (array_key_exists("id", $value)) {
                $memId = $value['id'] . ":" . $tableName . ":" . $this->_generatePrimId();
            } else {
                $memId = $this->_generatePrimId() . ":" . $tableName;
            }

            $this->_getCbHandler()->insert($memId, $value, 0);
        }
    }

    private function _sendViaZeroMq($data, $tableName)
    {

    }

    /**
     * @var \Processus\Lib\Db\CouchbaseClient
     */
    private $_cbHandler;

    /**
     * @return \Processus\Lib\Db\CouchbaseClient|\Processus\Lib\Db\Memcached
     */
    private function _getCbHandler()
    {
        if (!$this->_cbHandler) {
            $this->_cbHandler = new \Processus\Lib\Db\CouchbaseClient("bigdata-server:8091", "Administrator", "Administrator", "bigdata");
            //$this->_cbHandler = \Processus\Lib\Server\ServerFactory::memcachedFactory("bigdata-server", 11611, NULL, \Processus\Consta\MemcachedFactoryType::MEMCACHED_JSON);
        }

        return $this->_cbHandler;
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function _generatePrimId($key = "globId")
    {
        $primKey = "$key:primId";
        $incId   = $this->_getCbHandler()->fetch($primKey);
        if (!$incId) {
            $this->_getCbHandler()->insert($primKey, 1, 0);
        } else {
            $this->_getCbHandler()->increment($primKey);
        }

        return $incId;
    }

    /**
     * @var \Zend\Db\Adapter\AbstractAdapter
     */
    private $_dbHandler;

    /**
     * @return \Zend\Db\Adapter\AbstractAdapter
     */
    private function _getDbHandler()
    {
        if (empty($this->_dbHandler)) {
            $dbConfig         = new \Zend\Config\Config(array(
                'adapter' => 'PdoMysql',
                'params'  => array(
                    'host'           => 'bigdata-server',
                    'username'       => 'root',
                    'password'       => 'root',
                    'dbname'         => 'petvegas-dump',
                    'driver_options' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                    )
                )
            ));
            $this->_dbHandler = \Zend\Db\Db::factory($dbConfig->adapter, $dbConfig->params->toArray());
        }

        return $this->_dbHandler;
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
