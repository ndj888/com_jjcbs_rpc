<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/17
 * Time: 下午8:28
 */

// server rpc test
require '../vendor/autoload.php';

$clientConfig = new \src\bean\RpcClientConfig();
$clientConfig->setPort(8884);
$clientConfig->setListen('0.0.0.0');
$clientConfig->setServerName('testApp');
$clientConfig->setServerAddress(new \src\bean\Ipv4Address([
    'ip' => '192.168.0.6',
    'port' => '8881'
]));
$clientRpc = new \src\lib\RpcClientImpl();
$clientRpc->setRpcClientConfig($clientConfig);
$clientRpc->start();


//usleep(500);
$dnsInfo = $clientRpc->dnsNameParse('testApp');
var_dump($dnsInfo);
exit(0);

//while (true){
//    usleep(500);
//}