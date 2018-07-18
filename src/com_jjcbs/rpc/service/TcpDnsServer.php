<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 16:39
 */

namespace com_jjcbs\rpc\service;


use com_jjcbs\lib\Service;

/**
 * Class TcpDnsServer
 * @package com_jjcbs\rpc\service
 */
class TcpDnsServer extends Service
{
    /**
     * @var \swoole_client
     */
    private $client = null;
    public function exec()
    {
        // TODO: Implement exec() method.
    }

    /**
     * @return \swoole_client
     */
    public function getClient(): \swoole_client
    {
        return $this->client;
    }

    /**
     * @param \swoole_client $client
     */
    public function setClient(\swoole_client $client): void
    {
        $this->client = $client;
    }



}