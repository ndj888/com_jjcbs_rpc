<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 14:31
 */

namespace ext\interfaces;


/**
 * 响应数据接口
 * Interface ResponseData
 * @package ext\interfaces
 */
interface ResponseData
{
    public function getHeader(): array;

    public function getBody(): string;

    /**
     * 解析body数据
     * @param string $body
     * @param \Closure $closure
     * @return string
     */
    public function decodeBody(string $body , \Closure $closure) : string ;
}