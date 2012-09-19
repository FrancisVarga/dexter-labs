<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thelittlenerd87
 * Date: 23.08.12
 * Time: 13:29
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Task\Couchbase;
class SyncCB extends \Processus\Abstracts\AbstractTask
{

    public function run()
    {
        echo "Sync Starting" . PHP_EOL;

        $targetHost     = "couchbase-server";
        $targetPort     = "11211";
        $remoteApiUrl   = "http://ec2-54-247-28-110.eu-west-1.compute.amazonaws.com:8092";
        $remoteBucket   = "casino";
        $remoteViewName = "all";
        $remoteDesign   = "portal";

//        $cbAdapater = new \Application\Utils\CBAdapter();
//        $allData    = $cbAdapater->setApiUrl($remoteApiUrl)
//            ->setBucketName($remoteBucket)
//            ->setView($remoteViewName)
//            ->setDesign($remoteDesign)
//            ->fetchAll(array(
//                "include_docs" => TRUE,
//            )
//        );

        $allData    = json_decode(file_get_contents("http://ec2-54-247-28-110.eu-west-1.compute.amazonaws.com:8092/casino/_all_docs?include_docs=true"), TRUE);
        $totalItems = count($allData['rows']);

        echo "Total Sync items: $totalItems" . PHP_EOL;

        try {
            $insertAdapter = new \Application\Core\Lib\Db\MemcachedJson($targetHost, $targetPort);
            $result        = $insertAdapter->insert("foo", array("name" => "bar_" . mt_rand(0, 1394898304))); // Testing if couchbase responding or not! Expiredtime is 1 sec.
        } catch (\Exception $error) {
            var_dump($error);
        }

        $createdItems = 0;
        $errorItems   = 0;
        foreach ($allData['rows'] as $key => $value) {
            $data = $value['doc'];
            $meta = $data['meta'];
            $json = $data['json'];

            $result = $insertAdapter->insert($meta['id'], $json, 0);

            if ($result == 0) {
                $createdItems++;
            } else {
                $errorItems++;
            }
        }

        echo "Successfull Sync items: $createdItems" . PHP_EOL;
        echo "Error Sync items: $errorItems" . PHP_EOL;
        echo "Sync done" . PHP_EOL;
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
