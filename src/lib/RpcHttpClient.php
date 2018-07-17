<?php
/**
 * Created by PhpStorm.
 * User: longbob
 * Date: 2018/7/13 0013
 * Time: 14:31
 */

namespace src\lib;


use com_jjcbs\lib\Service;
use com_jjcbs\lib\ServiceFactory;
use src\bean\msg\RequestRpcBean;
use src\bean\msg\ResponseDataMsg;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * RPC 通信实现
 * Class RpcHttpClient
 * @package src\lib
 */
abstract class RpcHttpClient extends Service
{
    const protocol = 'http://';
    /**
     * @var RpcDns
     */
    private $dnsService = null;
    /**
     * @var
     */
    private $httpClient = null;
    /**
     * @var string
     */
    protected $serverName = '';

    protected $apiMap = [];

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->dnsService = ServiceFactory::getInstance(RpcDns::class);
    }

    public function exec()
    {
        // TODO: Implement exec() method.
    }

    /**
     * 发送请求
     * @param RequestRpcBean $request
     * @param string $fullUrl
     */
    public function send(string $fullUrl, RequestRpcBean $request) : ResponseDataMsg
    {
        $requestData = [
            'headers' => $request->getHeader(),
            'body' => $request->getBody()
        ];
        try {
            $req = $this->httpClient->request($request->getMethod(), $fullUrl, $requestData);
            $res = $req->getBody()->getContents();
            return new ResponseDataMsg(\json_decode($res, true));
        } catch (\Exception $e) {
            $error = 'request api error';
            Log::error($error);
            return $error;
        }

    }

    /**
     * 获取完整的url
     * @param string $apiName
     * @return string
     * @throws \Exception
     */
    public function getFullUrl(string $apiName): string
    {
        if (!array_key_exists($apiName, $this->apiMap)) throw new \Exception('api name found exist');
        return $this->parseDns() . $this->apiMap[$apiName];
    }

    /**
     * 将dns server_name 解析为ip port
     * @return string
     * @throws \Exception
     */
    protected function parseDns(): string
    {
        $serverInfo = $this->dnsService->parseDns($this->serverName);
        return self::protocol . $serverInfo->getAddress()->getIp() . ':' . $serverInfo->getAddress()->getPort();
    }
}