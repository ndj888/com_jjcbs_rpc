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
     * @var \swoole_client
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
        $this->client->send((new ResponseDataMsg([
            'eventName' => 'selectDns',
            'data' => [
                'serverName' => $serverName
            ]
        ]))->toJson());
        $bf = $this->client->recv();
        $res = new ResponseDataMsg(json_decode($bf , true));
        if ( $res->getResult() != 1) throw new \Exception('dns parse error');
        return new ServerInfo($res->getData());
    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->client->close();
    }

}