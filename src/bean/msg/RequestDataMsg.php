<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 15:20
 */

namespace ext\bean\msg;
use com_jjcbs\lib\SimpleRpc;


/**
 * 发送消息规范,消息应该是该对象转为json
 * Class RequestDataMsg
 * @package ext\bean\msg
 */
class RequestDataMsg extends SimpleRpc
{
    /**
     * 如 register unRegister check(ps:服务端检测客户端是否在心心跳包)
     * @var string
     */
    protected $eventName;

    /**
     * 消息的数据主体 不同的消息主体data不同
     * @var array
     */
    protected $data = [];

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }


}