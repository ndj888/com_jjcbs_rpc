<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 16:43
 */

namespace ext\bean;


use com_jjcbs\lib\SimpleRpc;

/**
 * RPC 客户端配置
 * Class RpcClientConfig
 * @package ext\bean
 */
class RpcClientConfig extends SimpleRpc
{
    /**
     * @var Ipv4Address
     */
    protected $serverAddress;
    protected $listen = '0.0.0.0';
    protected $port = 8088;
    protected $serverName = '';

    /**
     * @return Ipv4Address
     */
    public function getServerAddress(): Ipv4Address
    {
        return $this->serverAddress;
    }

    /**
     * @param Ipv4Address $serverAddress
     */
    public function setServerAddress(Ipv4Address $serverAddress): void
    {
        $this->serverAddress = $serverAddress;
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
     * @return string
     */
    public function getServerName(): string
    {
        return $this->serverName;
    }

    /**
     * @param string $serverName
     */
    public function setServerName(string $serverName): void
    {
        $this->serverName = $serverName;
    }


}