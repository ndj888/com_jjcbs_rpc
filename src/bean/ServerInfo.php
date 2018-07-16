<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:17
 */

namespace ext\bean;


use com_jjcbs\lib\SimpleRpc;

/**
 * 服务信息
 * Class ServerInfo
 * @package ext\bean
 */
class ServerInfo extends SimpleRpc
{
    protected $serverName = "";
    /**
     * @var Ipv4Address
     */
    protected $address = null;
    /**
     * 1 服务中 0 服务不可用
     * @var int
     */
    protected $status = 1;

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

    /**
     * @return Ipv4Address
     */
    public function getAddress(): Ipv4Address
    {
        if ( is_array($this->address)) $this->address = new Ipv4Address($this->address);
        return $this->address;
    }

    /**
     * @param Ipv4Address $address
     */
    public function setAddress(Ipv4Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


}