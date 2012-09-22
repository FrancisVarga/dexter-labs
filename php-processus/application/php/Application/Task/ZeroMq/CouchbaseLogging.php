<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/21/12
 * Time: 8:15 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\ZeroMq;
class CouchbaseLogging extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        $logData    = array(
            "id"       => mt_rand(0, 9879879879879898) . ":logging",
            "value"    => array(
                "message"  => "foo",
                "metaData" => "lol",
                "stack"    => var_export($this, TRUE),
            ),
            "expired"  => 0,
        );
        $serverData = array(
            "host"     => "localhost:8091",
            "user"     => "Administrator",
            "password" => "Administrator",
            "bucket"   => "default",
        );
        $message    = array(
            "logData"    => $logData,
            "serverData" => $serverData,
        );

        $rpcData = array(
            "id"        => 1,
            "params"    => array($message),
            "method"    => "ZeroMq.LoggingData.logToCouchbase",
        );

        $queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_PUSH, "MySock1");
        $queue->connect("tcp://127.0.0.1:5555");

        $queue->send(json_encode($rpcData), \ZMQ::MODE_NOBLOCK);
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
