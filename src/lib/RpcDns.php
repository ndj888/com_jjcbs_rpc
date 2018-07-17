<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 15:32
 */

namespace src\lib;
use com_jjcbs\lib\Service;
use src\bean\msg\ResponseDataMsg;
use src\bean\ServerInfo;

/**
 * 负责解析dns
 * Class RpcDns
 * @package src\lib
 */
class RpcDns extends Service
{
    /**
     * Dns tcp client
     * @var RpcClientImpl
     */
    private $client = null;
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function exec()
    {
        // TODO: Implement exec() method.
    }

    public function parseDns(string $serverName) : ServerInfo{
        return new ServerInfo($this->client->dnsNameParse($serverName));
    }

}