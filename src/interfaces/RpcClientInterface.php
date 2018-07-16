<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:01
 */

namespace ext\interfaces;
use ext\bean\Ipv4Address;
use ext\bean\ServerInfo;

/**
 * 内部通信rpc
 * Interface RpcClientInterface
 * @package ext\interfaces
 */
interface RpcClientInterface
{
    /**
     * 向服务管理中心注册一个服务
     * @param Ipv4Address $address
     * @param ServerInfo $serverInfo
     * @return bool
     */
    public function register(serverInfo $serverInfo) : bool;

    /**
     * 向服务管理中心注销一个服务
     * @param Ipv4Address $address
     * @param ServerInfo $serverInfo
     * @return bool
     */
    public function unRegister(ServerInfo $serverInfo) : bool ;

    /**
     * 将dns名称解析为ip地址和端口
     * @return array ["ip" => '0.0.0.0' , 'prot' => 8126]
     * @param string $serverName
     * @return array
     */
    public function dnsNameParse(string $serverName) : array ;

    /**
     * 异步
     * @param RequestData $requestData
     * @return ResponseData
     */
    public function sendRequest(RequestData $requestData) : ResponseData;
}