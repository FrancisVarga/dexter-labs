<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/23/12
 * Time: 4:37 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\JsonRpc\V1\ZeroMq\Service;
class StoringData extends \Processus\Abstracts\JsonRpc\AbstractJsonRpcService
{
    public function storeData($params)
    {
        $data       = $params['data'];
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

        $couchCli = new \Processus\Lib\Db\CouchbaseClient($serverData['host'], $serverData['user'], $serverData['password'], $serverData['bucket']);
        $couchCli->insert($data['id'], $data['value'], $data['expiredTime']);

        return;
    }
}
