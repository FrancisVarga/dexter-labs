<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rinomontiel
 * Date: 8/27/12
 * Time: 3:30 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class CouchbaseCDNUpdate extends \Processus\Abstracts\AbstractTask
{
    public function run()
    {
        $appSettingsMvo = $this->getApplicationContext()->getApplicationSettingsMvo();
        $data = get_object_vars($appSettingsMvo->getData());

        if (is_null($_SERVER['argv'][2]))
            throw new \Exception ("Please provide URL for the CDN");

        $data['CDN'] = $_SERVER['argv'][2];

        $appSettingsMvo->setData($data);
        $result = $appSettingsMvo->saveInMem();

        if ($result == 0)
            echo "\n--------------------\nSuccessfully updated the CDN\n--------------------\n\n\n";
        else
            echo "\n--------------------\nSomething went wrong updating the CDN, please retry or check Couchbase status.\n--------------------\n\n\n";
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
