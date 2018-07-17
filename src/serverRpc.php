<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/17
 * Time: 下午8:28
 */

// server rpc test
require '../vendor/autoload.php';
$serverConfig = new \src\bean\RpcServerConfig();
$serverConfig->setIsDaemon(false);
$serverConfig->setMaxServerMapSize(2048);
$serverConfig->setListen('0.0.0.0');
$serverConfig->setPort(8881);
$server = new \src\lib\RpcServerImpl();
$server->setConfig($serverConfig);
try{
    echo '服务管理-------启动';
    echo "\n listen {$serverConfig->getListen()}";
    echo "\n port {$serverConfig->getPort()}";
    $server->serverStart();
}catch (Exception $exception){
    echo $exception->getMessage();
}
exit(1);
