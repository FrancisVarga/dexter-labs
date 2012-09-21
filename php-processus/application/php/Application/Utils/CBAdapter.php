<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mirceapreotu
 * Date: 8/14/12
 * Time: 4:10 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Utils;
class CBAdapter implements \Processus\Interfaces\InterfaceDatabase
{
    private $_design;
    private $_view;
    private $_port = 8092;
    private $_hostName;
    private $_bucketName = "default";
    private $_apiUrl;

    /**
     * @var \Processus\Interfaces\InterfaceDatabase
     */
    private $_adapter = NULL;

    public function __constructor(\Processus\Interfaces\InterfaceDatabase $adapter = NULL)
    {
        if (is_null($adapter)) {
            $this->setAdapter(\Processus\Lib\Server\ServerFactory::memcachedFactory(NULL, NULL, NULL, \Processus\Consta\MemcachedFactoryType::MEMCACHED_JSON));
        }
    }

    /**
     * @return \Application\ApplicationContext|\Processus\ProcessusContext
     */
    protected function getApplicationContext()
    {
        return \Application\ApplicationContext::getInstance();
    }

    /**
     * @return string
     */
    private function _getCouchbaseApiUrl()
    {
        return "http://" . $this->getHostName() . ':' . $this->getPort() . "/" . $this->getBucketName() . "/_design/" . $this->getDesign() . "/_view/" . $this->getView();
    }


    /**
     * @param $params
     *
     * @return mixed
     */
    protected function _fetchView($params)
    {
        // Prepare query string
        $queryString = array();
        foreach ($params as $key => $value) {
            if (isset($value)) {
                if (is_array($value) || is_bool($value)) {
                    $value = json_encode($value);
                }
                $queryString[] = "$key=$value";
            }
        }

        $queryString = implode('&', $queryString);
        $dataUrl     = $this->_getCouchbaseApiUrl() . "?" . $queryString;

        $response = json_decode(file_get_contents($dataUrl), TRUE);
        return $response;
    }

    public function setDesign($design)
    {
        $this->_design = $design;
        return $this;
    }

    public function getDesign()
    {
        return $this->_design;
    }

    public function setView($view)
    {
        $this->_view = $view;
        return $this;
    }

    public function getView()
    {
        return $this->_view;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        if (!$this->_port) {
            $this->setPort(
                $this->getApplicationContext()->getRegistry()->getConfig('processus')
                    ->get('couchbaseConfig')
                    ->get('couchbaseRESTPort')
            );
        }
        return $this->_port;
    }

    /**
     * @param $port
     *
     * @return BaseMvo
     */
    public function setPort($port)
    {
        $this->_port = $port;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHostName()
    {
        if (!$this->_hostName) {
            $this->setHostName(
                $this->getApplicationContext()->getRegistry()->getConfig('processus')
                    ->get('couchbaseConfig')
                    ->get('couchbaseRESTHostName')
            );
        }
        return $this->_hostName;
    }

    /**
     * @param $hostName
     *
     * @return BaseMvo
     */
    public function setHostName($hostName)
    {
        $this->_hostName = $hostName;
        return $this;
    }

    public function setBucketName($bucketName)
    {
        $this->_bucketName = $bucketName;
        return $this;
    }

    public function getBucketName()
    {
        if (!$this->_bucketName) {
            $this->setBucketName(
                $this->getApplicationContext()->getRegistry()->getConfig('processus')
                    ->get('couchbaseConfig')
                    ->get('couchbaseRESTDefaultBucketName')
            );
        }
        return $this->_bucketName;
    }

    /**
     * @param null $key
     *
     * @return null
     */
    public function fetch($key = NULL)
    {
        if (is_null($key)) {
            return NULL;
        }
        $this->getAdapter()->fetch($key);
    }

    /**
     * @param null $key
     *
     * @return null
     */
    public function fetchOne($key = NULL)
    {
        if (is_null($key)) {
            return NULL;
        }
        $this->getAdapter()->fetch($key);
    }

    /**
     * @param array $viewParams
     *
     * @return mixed
     * @throws \Exception
     */
    public function fetchAll(array $viewParams = NULL)
    {
        if (is_null($this->getView())) {
            throw new \Exception("View is NULL");
        }
        return $this->_fetchView($viewParams);
    }

    /**
     * @param null $key
     * @param null $data
     *
     * @return void|\Zend\Db\Statement\Pdo
     * @throws \Exception
     */
    public function insert($key = NULL, $data = NULL)
    {
        if (is_null($key) || is_null($data)) {
            throw new \Exception("No data to insert");
        }
        $this->getAdapter()->insert($key);
    }

    /**
     * @param null $key
     * @param null $data
     *
     * @return void|\Zend\Db\Statement\Pdo
     * @throws \Exception
     */
    public function update($key = NULL, $data = NULL)
    {
        if (is_null($key) || is_null($data)) {
            throw new \Exception("No data to update");
        }
        $this->getAdapter()->update($key, $data);
    }

    /**
     * @param $adapter
     */
    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;
    }

    /**
     * @return null|\Processus\Interfaces\InterfaceDatabase
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    /**
     * @param $apiUrl
     *
     * @return CBAdapter
     */
    public function setApiUrl($apiUrl)
    {
        $this->_apiUrl = $apiUrl;
        return $this;
    }

    public function getApiUrl()
    {
        return $this->_apiUrl;
    }
}