<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/14/12
 * Time: 2:18 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\ZeroMq;
class ConnectClient extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        /* Create new queue object */
        $queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_PUSH, "MySock1");
        $queue->connect("tcp://127.0.0.1:5555");

        $mqData = array(
            "id"        => 1,
            "params"    => array(array(
                "message"  => "This is bullshit to.",
                "created"  => time(),
                "someData" => mt_rand(0, 49344409875093475),
            )),
            "method"    => "ZeroMq.TestZeroMq.testEcho",
            "extended"  => array(),
        );

        /* Assign socket 1 to the queue, send and receive */
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
        $queue->send(json_encode($mqData), \ZMQ::MODE_NOBLOCK);
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
