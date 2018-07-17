<?php
/**
 * Created by PhpStorm.
 * User: jjctc
 * Date: 2018/6/19 0019
 * Time: 17:40
 */

namespace src\fun\api;
use com_jjcbs\lib\ServiceFactory;
use src\lib\RequestToOpenApi;
use src\lib\RequestToTestServer;
use src\lib\RpcHttpClient;
use src\service\OpenApiService;
use Illuminate\Support\Facades\Log;

/**
 * OpenApi 快速调用方法
 * Class OpenApiFun
 * @package src\fun
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