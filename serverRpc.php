<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/17
 * Time: 下午8:28
 */

// server rpc test
define('ROOT_DIR',dirname(__FILE__));
require ROOT_DIR . '/vendor/autoload.php';
$cpuNum = \swoole_cpu_num();
$serverConfig = new \com_jjcbs\rpc\bean\RpcServerConfig();
$serverConfig->setIsDaemon(false);
$serverConfig->setMaxServerMapSize(2048);
$serverConfig->setListen('0.0.0.0');
$serverConfig->setPort(8881);
$serverConfig->setReactorNum($cpuNum * 2);
$serverConfig->setWorkerNum($cpuNum * 2 * 2);
$serverConfig->setHeartbeatCheckInterval(30);
$serverConfig->setHeartbeatIdleTime(600);
$server = new \com_jjcbs\rpc\lib\RpcServerImpl();
$server->setConfig($serverConfig);
try {
    echo '服务管理-------启动';
    echo "\n listen {$serverConfig->getListen()}";
    echo "\n port {$serverConfig->getPort()}";
    $server->serverStart();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
exit(1);
