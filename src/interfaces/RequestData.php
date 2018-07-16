<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:22
 */

namespace ext\interfaces;

/**
 * 请求数据接口
 * Interface RequestData
 * @package ext\interfaces
 */
interface RequestData
{
    /**
     * 获取通信使用的协议 如 http1.1
     * @return string
     */
    public function getProtocol(): string;

    /**
     * 设置通信使用的协议
     * @param string $protocol
     * @return mixed
     */
    public function setProtocol(string $protocol);

    public function setHeader(array $header);

    public function getHeader(): array;

    public function setBody(string $body);

    public function getBody(): string;

    /**
     * 对发送过去的数据进行编码
     * @param string $body
     * @param \Closure $fun
     * @return string
     */
    public function encodeData(string $body , \Closure $fun) : string ;
}