<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 15:32
 */

namespace com_jjcbs\rpc\lib;

use com_jjcbs\lib\Service;
use com_jjcbs\rpc\bean\Ipv4Address;
use com_jjcbs\rpc\bean\ServerInfo;

/**
 * 负责解析dns
 * Class RpcDns
 * @package com_jjcbs\rpc\lib
 */
class RpcDns extends Service
{
    /**
     * Dns tcp client
     * @var RpcClientImpl
     */
    private static $client = null;

    public function __construct($client)
    {
        self::$client = $client;
    }

    public function exec()
    {
        // TODO: Implement exec() method.
    }

    public function parseDns(string $serverName): ServerInfo
    {
        $arr = self::$client->dnsNameParse($serverName);
        if (empty($arr)) throw new \Exception('dns parase error');
        $arr['address'] = new Ipv4Address($arr['address'] ?? []);
        return new ServerInfo($arr);
    }

}