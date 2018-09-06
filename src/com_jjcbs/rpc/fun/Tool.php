<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 11:29
 */

namespace com_jjcbs\rpc\fun;


class Tool
{
    public static function is_json($json_str)
    {
        json_decode($json_str);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}