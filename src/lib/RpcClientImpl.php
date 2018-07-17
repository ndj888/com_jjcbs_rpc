<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 16:42
 */

namespace src\lib;


use src\bean\Ipv4Address;
use src\bean\msg\RequestDataMsg;
use src\bean\msg\ResponseDataMsg;
use src\bean\RpcClientConfig;
use src\bean\ServerInfo;
use src\interfaces\RequestData;
use src\interfaces\ResponseData;
use src\interfaces\RpcClientInterface;

class RpcClientImpl implements RpcClientInterface
{
    /**
     * 300 ms time out
     */
    const MAX_TIMEOUT = 0.3;
    /**
     * @var RpcClientConfig
     */
    protected $rpcClientConfig;

    /**
     * @param RpcClientConfig $rpcClientConfig
     */
    public function setRpcClientConfig(RpcClientConfig $rpcClientConfig): void
    {
        $this->rpcClientConfig = $rpcClientConfig;
    }


    public function register(ServerInfo $serverInfo): bool
    {
        // TODO: Implement register() method.
    }

    public function unRegister(ServerInfo $serverInfo): bool
    {
        // TODO: Implement unRegister() method.
    }

    public function dnsNameParse(string $serverName): array
    {
        // TODO: Implement dnsNameParse() method.
    }

    public function sendRequest(RequestData $requestData): ResponseData
    {
        // TODO: Implement sendRequest() method.
    }

    /**
     * 启动服务
     */
    public function start(){
        $client = new \Swoole\Client(SWOOLE_TCP );
        $serverAddress = $this->rpcClientConfig->getServerAddress();
        $serverInfo = new ServerInfo();
        $serverInfo->setServerName($this->rpcClientConfig->getServerName());
        $serverInfo->setAddress(new Ipv4Address([
            'ip' => $this->rpcClientConfig->getListen(),
            'port' => $this->rpcClientConfig->getPort()
        ]));
        $d = $serverInfo->toArray();
        $d['address'] = $serverInfo->getAddress()->toArray();
        $data = new RequestDataMsg([
            'eventName' => 'register',
            'data' => $d
        ]);
        if ( $client->connect($serverAddress->getIp() , $serverAddress->getPort() , self::MAX_TIMEOUT )){
            $client->send($data->toJson());
            $msg = $client->recv();
            $res = new ResponseDataMsg(json_decode($msg , true));
            if ( $res->getResult() == 1){
                echo $this->rpcClientConfig->getServerName() . '------------------------注册成功';
            }
            return $client;
        }
        return null;
    }

}