<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:15
 */

namespace ext\bean;
use com_jjcbs\lib\SimpleRpc;


/**
 * 描述一个iPV4地址
 * Class Ipv4Address
 * @package ext\bean
 */
class Ipv4Address extends SimpleRpc
{
    protected $ip = "";
    protected $port = 80;

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
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




}