<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/12 0012
 * Time: 15:23
 */

namespace ext\bean\msg;


use com_jjcbs\lib\SimpleRpc;

/**
 * 响应消息报文规范
 * Class ResponseDataMsg
 * @package ext\bean\msg
 */
class ResponseDataMsg extends SimpleRpc
{
    protected $eventName;
    protected $data = [];
    /**
     * 1 为成功 其它为失败
     * @var int
     */
    protected $result = 1;

    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param mixed $eventName
     */
    public function setEventName($eventName): void
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

    /**
     * @return int
     */
    public function getResult(): int
    {
        return $this->result;
    }

    /**
     * @param int $result
     */
    public function setResult(int $result): void
    {
        $this->result = $result;
    }


}