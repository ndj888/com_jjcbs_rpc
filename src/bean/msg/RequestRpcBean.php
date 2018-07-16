<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 15:42
 */

namespace ext\bean\msg;


use com_jjcbs\lib\SimpleRpc;

/**
 * 发送请求数据
 * Class RequestRpcBean
 * @package ext\bean\msg
 */
class RequestRpcBean extends SimpleRpc
{
    protected $header = [];
    protected $body = [];
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
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
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