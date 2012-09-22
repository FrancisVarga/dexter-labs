<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/21/12
 * Time: 7:05 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\JsonRpc\V1\ZeroMq\Service;
class LoggingData extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcService
{
    /**
     * @param $params
     */
    public function logToCouchbase($params)
    {
        $id         = $params['id'];
        $value      = $params['value'];
        $expireTime = $params['expired'];
        $serverData = $params['serverData'];

        if (empty($serverData['host'])) {
            $serverData['host'] = "localhost:8091";
        }

        if (empty($serverData['user'])) {
            $serverData['user'] = "Administrator";
        }

        if (empty($serverData['password'])) {
            $serverData['password'] = "Administrator";
        }

        if (empty($serverData['bucket'])) {
            $serverData['bucket'] = "default";
        }

        $couchCli   = new \Processus\Lib\Db\CouchbaseClient($serverData['host'], $serverData['user'], $serverData['password'], $serverData['bucket']);
        $counterID  = "counter:" . __METHOD__;
        $apiCounter = $couchCli->fetch();

        if ($apiCounter) {
            $couchCli->increment($counterID);
        } else {
            $couchCli->insert($counterID, 1);
        }
        $couchCli->insert($id, $value, $expireTime);

        return;
    }
}
