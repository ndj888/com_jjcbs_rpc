<?php
/**
 * Created by PhpStorm.
 * User: jjctc
 * Date: 2018/6/19 0019
 * Time: 17:40
 */

namespace ext\fun;
use com_jjcbs\lib\ServiceFactory;
use ext\lib\RequestToOpenApi;
use ext\lib\RequestToTestServer;
use ext\service\OpenApiService;
use Illuminate\Support\Facades\Log;

/**
 * OpenApi 快速调用方法
 * Class OpenApiFun
 * @package ext\fun
 */
class OpenApiFun
{

    public static function __callStatic($name, $arguments)
    {
        $openApi = ServiceFactory::getInstance(RequestToTestServer::class);
        try{
            $res = $openApi->send($openApi->getFullUrl($name) , $arguments[0]);
            return $res;
        }catch (\Exception $e){
            Log::error("api call error" . $e->getMessage());
        }
    }
}