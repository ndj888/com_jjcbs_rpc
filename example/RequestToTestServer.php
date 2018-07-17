<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 16:12
 */

namespace src\lib;


class RequestToTestServer extends RpcHttpClient
{
    protected $apiMap = [
        'test' => '/api/test'
    ];
    protected $serverName = 'testApp';
}