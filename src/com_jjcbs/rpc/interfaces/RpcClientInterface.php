<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:01
 */

namespace com_jjcbs\rpc\interfaces;
use com_jjcbs\rpc\bean\Ipv4Address;
use com_jjcbs\rpc\bean\msg\RequestDataMsg;
use com_jjcbs\rpc\bean\msg\ResponseDataMsg;
use com_jjcbs\rpc\bean\ServerInfo;

/**
 * 内部通信rpc
 * Interface RpcClientInterface
 * @package com_jjcbs\rpc\interfaces
 */
interface RpcClientInterface
{
    /**
     * 向服务管理中心注册一个服务
     * @param Ipv4Address $address
     * @param ServerInfo $serverInfo
     * @return bool
     */
    public function register() : bool;

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
     * @param RequestDataMsg $requestData
     * @return ResponseData
     */
    public function sendRequest(RequestDataMsg $requestData) : ResponseDataMsg;
}