<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/18
 * Time: 上午3:19
 */

namespace src\bean\msg;


use com_jjcbs\lib\SimpleRpc;

/**
 * 业务响应对象
 * Class ServiceResponseBean
 * @package src\bean\msg
 */
class ServiceResponseBean extends SimpleRpc
{
    protected $code = 0;
    protected $msg = '';
    protected $data = [];
    protected $result = 1;

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
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