<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:35
 */

namespace src\bean;

use com_jjcbs\lib\SimpleRpc;


/**
 * Class RpcServerConfig
 * @package src\bean
 */
class RpcServerConfig extends SimpleRpc
{
    /**
     * 最大服务注册size 默认2048满足一般需要了
     * @var int
     */
    protected $maxServerMapSize = 2048;
    protected $listen = '0.0.0.0';
    protected $port = 80;
    /**
     * tcp 轮询 每x秒发送心跳包
     * @var int
     */
    protected $tcp_check_time = 5;
    /**
     * 是否是守护进程
     * @var bool
     */
    protected $isDaemon = false;
    protected $reactor_num;
    protected $worker_num;
    /**
     * 达到该数重启worker 防止内存泄露
     * @var int
     */
    protected $max_request = 0;
    /**
     * 最大连接数
     * @var int
     */
    protected $max_conn = 1000;

    /**
     * @return int
     */
    public function getMaxServerMapSize(): int
    {
        return $this->maxServerMapSize;
    }

    /**
     * @param int $maxServerMapSize
     */
    public function setMaxServerMapSize(int $maxServerMapSize): void
    {
        $this->maxServerMapSize = $maxServerMapSize;
    }

    /**
     * @return string
     */
    public function getListen(): string
    {
        return $this->listen;
    }

    /**
     * @param string $listen
     */
    public function setListen(string $listen): void
    {
        $this->listen = $listen;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return bool
     */
    public function isDaemon(): bool
    {
        return $this->isDaemon;
    }

    /**
     * @param bool $isDaemon
     */
    public function setIsDaemon(bool $isDaemon): void
    {
        $this->isDaemon = $isDaemon;
    }

    /**
     * @return int
     */
    public function getTcpCheckTime(): int
    {
        return $this->tcp_check_time;
    }

    /**
     * @param int $tcp_check_time
     */
    public function setTcpCheckTime(int $tcp_check_time): void
    {
        $this->tcp_check_time = $tcp_check_time;
    }

    /**
     * @return mixed
     */
    public function getReactorNum()
    {
        return $this->reactor_num;
    }

    /**
     * @param mixed $reactor_num
     */
    public function setReactorNum($reactor_num): void
    {
        $this->reactor_num = $reactor_num;
    }

    /**
     * @return mixed
     */
    public function getWorkerNum()
    {
        return $this->worker_num;
    }

    /**
     * @param mixed $worker_num
     */
    public function setWorkerNum($worker_num): void
    {
        $this->worker_num = $worker_num;
    }

    /**
     * @return int
     */
    public function getMaxRequest(): int
    {
        return $this->max_request;
    }

    /**
     * @param int $max_request
     */
    public function setMaxRequest(int $max_request): void
    {
        $this->max_request = $max_request;
    }

    /**
     * @return int
     */
    public function getMaxConn(): int
    {
        return $this->max_conn;
    }

    /**
     * @param int $max_conn
     */
    public function setMaxConn(int $max_conn): void
    {
        $this->max_conn = $max_conn;
    }








}