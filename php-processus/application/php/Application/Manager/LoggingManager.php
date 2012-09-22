<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/14/12
 * Time: 10:39 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Manager;
class LoggingManager extends \Processus\Abstracts\Manager\AbstractManager
{
    /**
     * @param $loggingData
     * @param string $prefix
     * @return int
     */
    public function logDump($loggingData, $prefix = "logging:")
    {
        $memId        = "logging:primKey";
        $defaultCache = $this->getApplicationContext()->getDefaultCache(\Processus\Consta\MemcachedFactoryType::MEMCACHED_JSON);
        $primKey      = $defaultCache->fetch($memId);

        if (empty($primKey)) {
            $defaultCache->insert($memId, 0, 0);
        }

        $primId = $defaultCache->getMemClient()->increment($memId);
        $memId  = $prefix . $this->_getSubFix() . ":" . $primId;

        $defaultCache->insert($memId, $loggingData, 0);

        return $memId;
    }

    /**
     * @return mixed
     */
    private function _getSubFix()
    {
        $subFix = array("error", "info", "fatal", "warning", "deprecated");
        $randId = mt_rand(0, (count($subFix) - 1));

        return $subFix[$randId];
    }
}
