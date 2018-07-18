<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/17
 * Time: 下午8:28
 */

// server rpc test
require '../../../vendor/autoload.php';

$clientConfig = new \com_jjcbs\rpc\bean\RpcClientConfig();
$clientConfig->setPort(8884);
$clientConfig->setListen('0.0.0.0');
$clientConfig->setServerName('testDao');
$clientConfig->setServerAddress(new \com_jjcbs\rpc\bean\Ipv4Address([
    'ip' => '192.168.0.6',
    'port' => '8881'
]));
$clientRpc = new \com_jjcbs\rpc\lib\RpcClientImpl();
$clientRpc->setRpcClientConfig($clientConfig);
$clientRpc->start();


//usleep(500);
//$dnsInfo = $clientRpc->dnsNameParse('testApp');
//var_dump($dnsInfo);
//exit(0);

//while (true){
//    usleep(500);
//}

$res = \com_jjcbs\rpc\fun\api\TestApiFun::test($clientRpc , new \com_jjcbs\rpc\bean\msg\RequestRpcBean([
    'method' => 'POST'
]));
echo $res->getMsg();