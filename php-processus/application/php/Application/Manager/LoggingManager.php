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
        $defaultCache = $this->getApplicationContext()->getDefaultCache();
        $primKey      = $defaultCache->fetch($memId);

        if (empty($primKey)) {
            $defaultCache->insert($memId, 0, 0);
        }

        $id    = $defaultCache->getMemClient()->increment($memId);
        $memId = $prefix . $id;

        return $defaultCache->insert($memId, $loggingData, 0);
    }
}
