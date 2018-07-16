<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 15:04
 */

namespace ext\lib;

use ext\bean\Ipv4Address;
use ext\bean\msg\RequestDataMsg;
use ext\bean\msg\ResponseDataMsg;
use ext\bean\RpcServerConfig;
use ext\bean\ServerInfo;
use ext\fun\Tool;
use ext\interfaces\RpcServerInterface;

/**
 * Rpc server 端实现
 * Class RpcServerImpl
 * @package ext\lib
 */
class RpcServerImpl implements RpcServerInterface
{
    /**
     * 每30s 广播一次
     */
    const broadcastTime = 30 * 1000;
    /**
     * @var RpcServerConfig $rpcServerConfig
     */
    protected $rpcServerConfig;
    /**
     * @var \Swoole\Table
     */
    protected $serverTable;

    /**
     * [serverName1 = > [0 , 1] , serverName2 => [0,1]]
     * @var array
     */
    protected $serverNameIndexArr = [];
    /**
     * [$fd1 => $serverName1]
     * @var array
     */
    protected $fdServerInfo = [];


    public function getConfig(): RpcServerConfig
    {
        // TODO: Implement getConfig() method.
        return $this->rpcServerConfig;
    }

    public function setConfig(RpcServerConfig $rpcServerConfig)
    {
        // TODO: Implement setConfig() method.
        $this->rpcServerConfig = $rpcServerConfig;
    }

    public function serverStart()
    {
        // TODO: Implement serverStart() method.
        if (empty($this->rpcServerConfig)) throw new \Exception("请设置rpcServerConfig");
        //set serverTable
        $this->serverTable = new \Swoole\Table($this->rpcServerConfig->getMaxServerMapSize());
        $this->serverTable->column('serverName' , \swoole_table::TYPE_STRING , 32);
        $this->serverTable->column('address' , \swoole_table::TYPE_STRING , 2048);
        $this->serverTable->column('status' , \swoole_table::TYPE_INT);
        if ( ! $this->serverTable->create()){
            echo '内存表创建失败';
            die;
        }
        $serv = new \Swoole\Server($this->rpcServerConfig->getListen()
            , $this->rpcServerConfig->getPort(), SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

        // 建立连接
        $serv->on('connect', function ($serv, $fd) {
            echo "Client-Connect.\n";
        });
        // 收到消息
        $serv->on('receive', function ($serv, $fd, $from_id, $data) {
            try {
                if ( !Tool::is_json($data)) throw new \Exception('error data input');
                echo 'input : ' . $data . "\n";
                $raw = new RequestDataMsg(\json_decode($data , true));
                switch ($raw->getEventName()) {
                    case 'register':
                        $body = new ServerInfo($raw->getData());
                        $index = $fd;
                        if ( empty($this->serverNameIndexArr[$body->getServerName()] )) $this->serverNameIndexArr[$body->getServerName()] = [];
                        array_push($this->serverNameIndexArr[$body->getServerName()] , $index);
                        $this->fdServerInfo[$fd] = $body;
                        $signKey = md5($body->getServerName() . $index);
                        if ($this->serverTable->get($signKey) == false) {
                            // key not exist
                            // set info to table
                            $d = $body->toArray();
                            $d['address'] = $body->getAddress()->toJson();
                            $this->serverTable->set($signKey, $d);
                        }
                        //response
                        $serv->send($fd , json_encode(ResponseMessage::succeed([] , 'register succeed')));
                        break;
                    case 'unRegister':
                        $body = new ServerInfo($raw->getData());
                        $serverKey = md5($body->getServerName());
                        $this->unRegister($this->getServerTableData($serverKey));
                        $serv->send(json_encode(ResponseMessage::succeed([] , 'unregister succeed')));
                        break;
                    /**
                     * DNS 查询
                     */
                    case 'selectDns' :
                        $sn = $raw->getData()['serverName'];
                        if ( !array_key_exists($sn , $this->serverNameIndexArr)){
                            throw new \Exception('server not found');
                        }
                        $data = $this->getServerTableData(md5($sn . $this->dnsSelect($this->serverNameIndexArr[$sn])));
                        $serv->send($fd , \json_encode($data->toJson()));
                        break;
                    default:
                        $msg = new ResponseDataMsg([
                            'eventName' => 'noNone',
                            'data' => ['msg' => 'not found event name']
                        ]);
                        $serv->send($fd, $msg->toJson());
                        break;
                }
            } catch (\Exception $e) {
                $errMsg = 'error: ' . $e->getMessage() . "\n";
                echo $errMsg;
                $serv->send($fd , $errMsg);
                $serv->close($fd);
            }
        });
        // 关闭连接
        $serv->on('close', function ($serv, $fd) {
            echo 'Client-Close.\n';
            try {
                if ( array_key_exists($fd , $this->fdServerInfo)) $this->unRegister($this->fdServerInfo[$fd]);
            } catch (\Exception $e) {
                echo 'close error ' . $e->getMessage();
            } finally {
                unset($this->fdServerInfo[$fd]);
            }
        });
        // 启动服务
        $serv->start();
    }


    /**
     * 注销当前服务
     * @param ServerInfo $info
     */
    private function unRegister(ServerInfo $info)
    {
        $serverName = $info->getServerName();
        $indexArr = $this->serverNameIndexArr[$serverName];
        foreach ($indexArr as $i) {
            $signKey = md5($serverName . $i);
            $body = $this->getServerTableData($signKey);
            if ($body->getAddress()->getPort() == $info->getAddress()->getPort() && $body->getAddress()->getIp() == $info->getAddress()->getIp()) {
                // found
                $this->serverTable->del($signKey);
                break;
            }
        }
    }


    /**
     * dns 负载均衡选择算法
     * @param array $arr
     * @return mixed
     */
    private function dnsSelect(array $arr){
        return $arr[array_rand($arr)];
    }

    private function getServerTableData(string $signKey) : ServerInfo {
        $arr = $this->serverTable->get($signKey);
        if ( ! $arr) throw new \Exception('server not found');
        $serverInfo = new ServerInfo($arr);
        $serverInfo->setAddress(new Ipv4Address(\json_decode($arr['address'] , true)));
        return $serverInfo;
    }

}