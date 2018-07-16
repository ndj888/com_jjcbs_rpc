<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:34
 */

namespace ext\interfaces;

use ext\bean\RpcServerConfig;


/**
 * RPC server 中心
 * Interface RpcServerInterface
 * @package ext\interfaces
 */
interface RpcServerInterface
{
    public function getConfig(): RpcServerConfig;

    public function setConfig(RpcServerConfig $rpcServerConfig);

    /**
     * 启动Rpc 注册中心服务 将阻塞等待连接
     * @return mixed
     */
    public function serverStart();


}