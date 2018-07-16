<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/6/20 0020
 * Time: 14:59
 */

namespace ext\lib;


class ResponseMessage
{
    private static $msg = [
        'code' => 100,
        'msg' => '',
        'data' => [],
        'result' => 0
    ];

    public static function succeed(array $data =[] , string $msg = '' , int $code = 200){
        self::$msg['code'] = $code;
        self::$msg['result'] = 1;
        self::$msg['msg'] = $msg;
        self::$msg['data'] = $data;
        return self::$msg;
    }

    public static function error(string $msg = ''  ,array $data = [] , int $code = 100){
        self::$msg['code'] = $code;
        self::$msg['result'] = 0;
        self::$msg['msg'] = $msg;
        self::$msg['data'] = $data;
        return self::$msg;
    }
}