<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/18
 * Time: 上午3:31
 */

namespace src\fun\api;


use src\lib\RequestToTestServer;

class TestApiFun extends OpenApiFun
{
    protected static $apiServiceName = RequestToTestServer::class;
}