<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/18 0018
 * Time: 15:21
 */

namespace com_jjcbs\rpc\lib;


/**
 * 协程实现timer
 * Class GoTimer
 * @package com_jjcbs\rpc\lib
 */
class GoTimer
{
    public static function start(int $time , \Closure $func , array $param = []){
        go(function() use ($param , $time , $func){
            while (true){
                $func($param);
                \co::sleep($time);
            }
        });
    }
}