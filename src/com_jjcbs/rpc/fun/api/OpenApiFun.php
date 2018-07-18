<?php
/**
 * Created by PhpStorm.
 * User: jjctc
 * Date: 2018/6/19 0019
 * Time: 17:40
 */

namespace com_jjcbs\rpc\fun\api;
use com_jjcbs\lib\ServiceFactory;
use com_jjcbs\rpc\lib\RequestToOpenApi;
use com_jjcbs\rpc\lib\RequestToTestServer;
use com_jjcbs\rpc\lib\RpcHttpClient;
use com_jjcbs\rpc\service\OpenApiService;
use Illuminate\Support\Facades\Log;

/**
 * OpenApi 快速调用方法
 * Class OpenApiFun
 * @package com_jjcbs\rpc\fun
 */
abstract class OpenApiFun
{

    /**
     * @var RpcHttpClient
     */
    protected static $apiServiceName;

    public static function __callStatic($name, $arguments)
    {
        $openApi = ServiceFactory::getInstance(static::$apiServiceName , [$arguments[0]]);
        try{
            $res = $openApi->send($openApi->getFullUrl($name) , $arguments[1]);
            return $res;
        }catch (\Exception $e){
            Log::error("api call error" . $e->getMessage());
        }
    }
}