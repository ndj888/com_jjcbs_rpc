<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:35
 */

namespace com_jjcbs\rpc\bean;

use com_jjcbs\lib\SimpleRpc;


/**
 * Class RpcServerConfig
 * @package com_jjcbs\rpc\bean
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
     * 是否是守护进程
     * @var bool
     */
    protected $isDaemon = false;
    protected $reactorNum = 2;
    protected $workerNum = 4;
    protected $maxRequest = 0;
    /**
     * 最大处理连接数
     * @var int 
     */
    protected $maxCoon = 1000;
    /**
     * 轮询tcp时间
     * @var int
     */
    protected $heartbeat_check_interval = 30;
    /**
     * tcp 连接闲置时间 超过这个没有回应的连接会被回收
     * @var int
     */
    protected $heartbeat_idle_time = 60;

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
    public function getReactorNum(): int
    {
        return $this->reactorNum;
    }

    /**
     * @param int $reactorNum
     */
    public function setReactorNum(int $reactorNum): void
    {
        $this->reactorNum = $reactorNum;
    }

    /**
     * @return int
     */
    public function getWorkerNum(): int
    {
        return $this->workerNum;
    }

    /**
     * @param int $workerNum
     */
    public function setWorkerNum(int $workerNum): void
    {
        $this->workerNum = $workerNum;
    }

    /**
     * @return int
     */
    public function getMaxRequest(): int
    {
        return $this->maxRequest;
    }

    /**
     * @param int $maxRequest
     */
    public function setMaxRequest(int $maxRequest): void
    {
        $this->maxRequest = $maxRequest;
    }

    /**
     * @return int
     */
    public function getMaxCoon(): int
    {
        return $this->maxCoon;
    }

    /**
     * @param int $maxCoon
     */
    public function setMaxCoon(int $maxCoon): void
    {
        $this->maxCoon = $maxCoon;
    }

    /**
     * @return int
     */
    public function getHeartbeatCheckInterval(): int
    {
        return $this->heartbeat_check_interval;
    }

    /**
     * @param int $heartbeat_check_interval
     */
    public function setHeartbeatCheckInterval(int $heartbeat_check_interval): void
    {
        $this->heartbeat_check_interval = $heartbeat_check_interval;
    }

    /**
     * @return int
     */
    public function getHeartbeatIdleTime(): int
    {
        return $this->heartbeat_idle_time;
    }

    /**
     * @param int $heartbeat_idle_time
     */
    public function setHeartbeatIdleTime(int $heartbeat_idle_time): void
    {
        $this->heartbeat_idle_time = $heartbeat_idle_time;
    }






}