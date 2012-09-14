<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippsterkiller
 * Date: 9/14/12
 * Time: 1:52 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\ZeroMq;
class StartServer extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        $this->_queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REP);
        $this->_queue->bind("tcp://127.0.0.1:5555");

        /* Loop receiving and echoing back */
        while ($message = $this->_queue->recv()) {
            echo "Got message: $message\n";
            /* echo back the message */
            $this->_queue->send($message);
        }
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
