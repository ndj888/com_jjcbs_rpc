<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 16:42
 */

namespace com_jjcbs\rpc\lib;


use com_jjcbs\rpc\bean\Ipv4Address;
use com_jjcbs\rpc\bean\msg\RequestDataMsg;
use com_jjcbs\rpc\bean\msg\ResponseDataMsg;
use com_jjcbs\rpc\bean\RpcClientConfig;
use com_jjcbs\rpc\bean\ServerInfo;
use com_jjcbs\rpc\interfaces\RpcClientInterface;

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
     * @var \swoole_client
     */
    private static $client;

    /**
     * @param RpcClientConfig $rpcClientConfig
     */
    public function setRpcClientConfig(RpcClientConfig $rpcClientConfig): void
    {
        $this->rpcClientConfig = $rpcClientConfig;
    }


    public function register(): bool
    {
        // TODO: Implement register() method.

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
        $res = $this->sendRequest($data);
        if ($res->getResult() == 1) {
            echo $this->rpcClientConfig->getServerName() . '------------------------注册成功';
            return true;
        }
        return false;
    }

    public function unRegister(ServerInfo $serverInfo): bool
    {
        // TODO: Implement unRegister() method.
    }

    public function dnsNameParse(string $serverName): array
    {
        // TODO: Implement dnsNameParse() method.
        $res = $this->sendRequest(new RequestDataMsg([
            'eventName' => 'selectDns',
            'data' => [
                'serverName' => $serverName
            ]
        ]));
        return $res->getData() ?? [];
    }

    public function sendRequest(RequestDataMsg $requestData): ResponseDataMsg
    {
        // TODO: Implement sendRequest() method.
        $this->reConnect();
        self::$client->send($requestData->toJson());
        $msg = self::$client->recv();
        echo('dnsMsg['.$msg.']');
        $data = json_decode($msg, true);
        return new ResponseDataMsg($data ?? []);
    }

    /**
     * 启动服务
     */
    public function start()
    {
        self::$client = new \Swoole\Client(SWOOLE_TCP | SWOOLE_KEEP);

        $this->connect();
        $this->register();
    }

    /**
     * 启动心跳包
     */
    public function startBeat(){
        if ( self::$client->isConnected()){
            // 启动定时心跳
            GoTimer::start($this->rpcClientConfig->getTcpUpTime() , function(array $param = []){
                echo 'send rect';
                $param['client']->send((new RequestDataMsg([
                    'eventName' => 'beat',
                    'data' => []
                ]))->toJson());
            } , ['client' => self::$client]);
        }
    }

    /**
     * 断线重连
     */
    private function reConnect()
    {
        if (!self::$client->isConnected()) {
            //clear last timer
            $this->connect();
        }
    }

    private function connect()
    {
        $serverAddress = $this->rpcClientConfig->getServerAddress();
        self::$client->connect($serverAddress->getIp(), $serverAddress->getPort(), self::MAX_TIMEOUT);

    }

}