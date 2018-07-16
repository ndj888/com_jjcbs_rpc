<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:35
 */

namespace ext\bean;

use com_jjcbs\lib\SimpleRpc;


/**
 * Class RpcServerConfig
 * @package ext\bean
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






}