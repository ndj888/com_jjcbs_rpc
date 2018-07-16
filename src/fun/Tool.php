<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 11:29
 */

namespace ext\fun;


class Tool
{
    public static function is_json($json_str) {
        $json_str = str_replace('＼＼', '', $json_str);
        $out_arr = array();
        preg_match('/{.*}/', $json_str, $out_arr);
        if (!empty($out_arr)) {
            $result = json_decode($out_arr[0], TRUE);
        } else {
            return false;
        }
        return $result;
    }
}