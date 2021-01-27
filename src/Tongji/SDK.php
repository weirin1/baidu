<?php

namespace Weirin\Baidu\Tongji;

/**
 *  百度统计接口
 *  @author  Lcn <378107001@qq.com>
 *  @version 1.0
 *
 *
 * @package Baidu\Tongji
 */
class SDK
{
    const LOGIN_URL = 'https://api.baidu.com/sem/common/HolmesLoginService';
    const API_URL = 'https://api.baidu.com/json/tongji/v1/ReportService';
    
    private $username;
    private $password;
    private $token;
    private $uuid;
    private $accountType;

    private $ucid;
    private $st;

    private $service;
    
    public $debug =  false;

    /**
     * @param $options
     */
    public function __construct($options)
    {
        $this->username = isset($options['username']) ? $options['username'] : '';
        $this->password = isset($options['password']) ? $options['password'] : '';
        $this->token = isset($options['token']) ? $options['token'] : '';
        $this->uuid = isset($options['uuid']) ? $options['uuid'] : ''; // used to identify your device, for instance: MAC address
        $this->accountType = isset($options['accountType']) ? $options['accountType'] : 1; // ZhanZhang:1,FengChao:2,Union:3,Columbus:4
        $this->debug = isset($options['debug']) ? $options['debug'] : false;
    }

    /*
     * 登录
     */
    private function login()
    {
        $loginService = new LoginService(self::LOGIN_URL, $this->uuid);
        $loginService->preLogin($this->username, $this->token);
        $ret = $loginService->doLogin($this->username, $this->password, $this->token);

        $this->ucid = $ret['ucid'];
        $this->st = $ret['st'];
    }

    /*
     * 初始化接口
     */
    private function initReportService()
    {
        $this->login();

        $this->service = new ReportService(self::API_URL, $this->username, $this->token, $this->accountType, $this->uuid, $this->ucid, $this->st);
    }

    /*
     * 获取站点列表
     * @return array
     */
    public function getSiteList()
    {
        if (!$this->service) {
            $this->initReportService();
        }

        $ret = $this->service->getSiteList();

        return $ret;
    }

    /*
     * 获取站点数据
     * @param $params
     * @return array
     */
    public function getData($params)
    {
        if (!$this->service) {
            $this->initReportService();
        }

        $ret = $this->service->getData($params);

        return $ret;
    }
}
