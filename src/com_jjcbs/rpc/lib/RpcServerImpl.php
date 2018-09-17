<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 15:04
 */

namespace com_jjcbs\rpc\lib;

use com_jjcbs\rpc\bean\Ipv4Address;
use com_jjcbs\rpc\bean\msg\RequestDataMsg;
use com_jjcbs\rpc\bean\RpcServerConfig;
use com_jjcbs\rpc\bean\ServerInfo;
use com_jjcbs\rpc\fun\Tool;
use com_jjcbs\rpc\interfaces\RpcServerInterface;

/**
 * Rpc server 端实现
 * Class RpcServerImpl
 * @package com_jjcbs\rpc\lib
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
     * @var \Swoole\Table
     */
    protected $serverNameIndexArr;


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
        $this->serverTable->column('serverName', \swoole_table::TYPE_STRING, 32);
        $this->serverTable->column('address', \swoole_table::TYPE_STRING, 2048);
        $this->serverTable->column('status', \swoole_table::TYPE_INT);
        $this->serverTable->column('fd', \swoole_table::TYPE_INT);
        // set serverNameIndexTable
        $this->serverNameIndexArr = new \Swoole\Table($this->rpcServerConfig->getMaxServerMapSize());
        $this->serverNameIndexArr->column('index', \swoole_table::TYPE_STRING, 5096);
        if (!$this->serverTable->create() || !$this->serverNameIndexArr->create()) {
            echo '内存表创建失败';
            die;
        }
        $serv = new \Swoole\Server($this->rpcServerConfig->getListen()
            , $this->rpcServerConfig->getPort(), SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $serv->set([
            'heartbeat_check_interval' => $this->rpcServerConfig->getHeartbeatCheckInterval(),
            'heartbeat_idle_time' => $this->rpcServerConfig->getHeartbeatIdleTime(),
            'max_request' => $this->rpcServerConfig->getMaxRequest(),
            'max_conn' => $this->rpcServerConfig->getMaxCoon(),
            'reactor_num' => $this->rpcServerConfig->getReactorNum(),
            'worker_num' => $this->rpcServerConfig->getWorkerNum()
        ]);
        // 建立连接
        $serv->on('connect', function ($serv, $fd) {
            echo "Client-Connect.\n";
        });
        // 收到消息
        $serv->on('receive', function ($serv, $fd, $from_id, $data) {
            try {
                if (!Tool::is_json($data)) throw new \Exception('error data input');
                echo 'input : ' . $data . "\n";
                $raw = new RequestDataMsg(\json_decode($data, true));
                switch ($raw->getEventName()) {
                    case 'register':
                        $index = $fd;
                        $tempArr = $raw->getData();
                        $tempArr['fd'] = $index;
                        $tempArr['address'] = new Ipv4Address($tempArr['address']);
                        $body = new ServerInfo($tempArr);

                        $this->serverNameIndexArrPush($body->getServerName(), $index);
                        $signKey = $body->getServerName() . $index;
                        if ($this->serverTable->get($signKey) == false) {
                            // key not exist
                            // set info to table
                            $d = $body->toArray();
                            $d['address'] = $body->getAddress()->toJson();
                            $this->serverTable->set($signKey, $d);
                        }
                        //response
                        $serv->send($fd, ResponseMessage::succeed('register', [], 'register succeed')->toJson());
                        break;
                    case 'unRegister':
                        $body = new ServerInfo($raw->getData());
                        $serverKey = $body->getServerName() . $fd;
                        $this->unRegister($this->getServerTableData($serverKey), $fd);
                        $serv->send($fd, ResponseMessage::succeed('unRegister', [], 'unregister succeed')->toJson());
                        break;
                    /**
                     * DNS 查询
                     */
                    case 'selectDns' :
                        $sn = $raw->getData()['serverName'];
                        $arr = $this->getServerNameIndexArr($sn);
                        $data = $this->getServerTableData($sn . $this->dnsSelect($arr));
                        var_export($data);
                        $serv->send($fd, ResponseMessage::succeed('selectDns', $data->toArray())->toJson());
                        break;
                    case 'beat':
                        // 心跳包
                        $serv->send($fd, ResponseMessage::succeed('beat', [], 'succeed')->toJson());
                        break;
                    default:
                        $serv->send($fd, ResponseMessage::error('noNone', 'not found')->toJson());
                        break;
                }
            } catch (\Exception $e) {
                $errMsg = 'error: ' . $e->getMessage() . "\n";
                echo $errMsg;
                $serv->send($fd, ResponseMessage::error('error', $errMsg)->toJson());
//                $serv->close($fd);
            }
        });
        // 关闭连接
        $serv->on('close', function ($serv, $fd) {
            echo 'Client-Close.\n';
            try {
                $this->unRegister($this->getServerTableData($this->findServerNameByFd($fd) . $fd), $fd);
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
     * @param  int $fd
     * @throws \Exception
     */
    private function unRegister(ServerInfo $info, int $fd)
    {
        $serverName = $info->getServerName();
        // del the fd
        $this->serverTable->del($serverName . $fd);
        $this->serverNameIndexArrDel($serverName, $fd);
    }


    /**
     * dns 负载均衡选择算法
     * @param array $arr
     * @return mixed
     */
    private function dnsSelect(array $arr)
    {
        return empty($arr) ? [] : $arr[array_rand($arr)];
    }

    private function getServerTableData(string $signKey): ServerInfo
    {
        $arr = $this->serverTable->get($signKey);
        if (!$arr) throw new \Exception('server not found');
        $serverInfo = new ServerInfo($arr);
        $serverInfo->setAddress(new Ipv4Address(\json_decode($arr['address'], true)));
        return $serverInfo;
    }

    private function getServerNameIndexArr(string $name): array
    {
        $d = [];
        if ($this->serverNameIndexArr->exist($name)) {
            $d = json_decode($this->serverNameIndexArr->get($name)['index'] ?? '{}', true);
        }
        return $d;
    }

    private function serverNameIndexArrPush(string $key, int $i)
    {
        $arr = $this->getServerNameIndexArr($key);
        array_push($arr, $i);
        $this->serverNameIndexArrSet($key, $arr);
    }

    /**
     * 从数组中删除指定值
     * @param string $key
     * @param int $v
     */
    private function serverNameIndexArrDel(string $key, int $v)
    {
        $arr = $this->getServerNameIndexArr($key);
        $i = array_search($v, $arr);
        if ($i !== false) {
            unset($arr[$i]);
        }
        $this->serverNameIndexArrSet($key, $arr);

    }

    private function serverNameIndexArrSet(string $key, array $arr = [])
    {
        $this->serverNameIndexArr->set($key, ['index' => json_encode($arr, true)]);
    }

    /**
     * 通过 fd 查找 serverName
     * @param int $fd
     * @return string
     */
    private function findServerNameByFd(int $fd = 0): string
    {
        foreach ($this->serverTable as $v) {
            if ($v['fd'] == $fd) return $v['serverName'];
        }
        return '';
    }

}