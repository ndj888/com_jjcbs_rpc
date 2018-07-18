<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/6/20 0020
 * Time: 14:59
 */

namespace com_jjcbs\rpc\lib;


use com_jjcbs\rpc\bean\msg\ResponseDataMsg;

class ResponseMessage
{

    public static function succeed(string $eventName , array $data =[] , string $msg = '') : ResponseDataMsg {
        $data['msg'] = $msg;
        return new ResponseDataMsg([
            'eventName' => $eventName,
            'data' => $data,
            'code' => 1
        ]);
    }

    public static function error(string $eventName , string $msg = ''  ,array $data = []) : ResponseDataMsg {
        $data['msg'] = $msg;
        return new ResponseDataMsg([
            'eventName' => $eventName,
            'data' => $data,
            'code' => 0
        ]);
    }
}