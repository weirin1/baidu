<?php

namespace Weirin\Baidu\Tongji;

/**
 * ReportService
 */
class ReportService
{
    private $apiUrl;
    private $userName;
    private $token;
    private $ucid;
    private $st;
    private $accountType;
    private $uuid;
    
    /**
     * construct
     * @param string $apiUrl
     * @param string $userName
     * @param string $token
     * @param string $ucid
     * @param int $accountType
     * @param string $st
     */
    public function __construct($apiUrl, $userName, $token, $accountType, $uuid, $ucid, $st)
    {
        $this->apiUrl = $apiUrl;
        $this->userName = $userName;
        $this->token = $token;
        $this->ucid = $ucid;
        $this->st = $st;
        $this->accountType = $accountType;
        $this->uuid = $uuid;
    }
    
    /**
     * get site list
     * @return array
     */
    public function getSiteList()
    {
      //  echo '----------------------get site list----------------------' . PHP_EOL;
        $apiConnection = new DataApiConnection();
        $apiConnection->init($this->apiUrl . '/getSiteList', $this->ucid, $this->uuid);

        $apiConnectionData = array(
            'header' => array(
                'username' => $this->userName,
                'password' => $this->st,
                'token' => $this->token,
                'account_type' => $this->accountType,
            ),
            'body' => null,
        );
        $apiConnection->POST($apiConnectionData);
        
        return array(
            'header' => $apiConnection->retHead,
            'body' => $apiConnection->retBody,
            'raw' => $apiConnection->retRaw,
        );
    }

    /**
     * get data
     * @param array $parameters
     * @return array
     */
    public function getData($parameters)
    {
       // echo '----------------------get data----------------------' . PHP_EOL;
        $apiConnection = new DataApiConnection();
        $apiConnection->init($this->apiUrl . '/getData', $this->ucid);

        $apiConnectionData = array(
            'header' => array(
                'username' => $this->userName,
                'password' => $this->st,
                'token' => $this->token,
                'account_type' => $this->accountType,
            ),
            'body' => $parameters,
        );
        $apiConnection->POST($apiConnectionData);
        
        return array(
            'header' => $apiConnection->retHead,
            'body' => $apiConnection->retBody,
            'raw' => $apiConnection->retRaw,
        );
    }
}
