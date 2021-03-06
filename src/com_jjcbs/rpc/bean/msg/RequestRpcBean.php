<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 15:42
 */

namespace com_jjcbs\rpc\bean\msg;


use com_jjcbs\lib\SimpleRpc;

/**
 * 发送请求数据
 * Class RequestRpcBean
 * @package com_jjcbs\rpc\bean\msg
 */
class RequestRpcBean extends SimpleRpc
{
    protected $header = [];
    protected $body;
    protected $method = 'GET';

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     */
    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }



    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }




}