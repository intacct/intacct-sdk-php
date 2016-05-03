<?php

/*
 * Copyright 2016 Intacct Corporation.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy 
 * of the License at
 * 
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * or in the "LICENSE" file accompanying this file. This file is distributed on 
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either 
 * express or implied. See the License for the specific language governing 
 * permissions and limitations under the License.
 */

namespace Intacct\Credentials;

use Intacct\Content;
use Intacct\Functions\GetAPISession;
use Intacct\Xml\RequestHandler;
use Intacct\Xml\RequestBlock;
use Intacct\Xml\SynchronousResponse;
use Intacct\Endpoint;

class SessionProvider
{
    
    /**
     *
     * @var array
     */
    private $lastExecution = [];
    
    public function __construct()
    {
        //nothing to see here
    }
    
    /**
     * 
     * @return array
     */
    public function getLastExecution()
    {
        return $this->lastExecution;
    }

    /**
     * @param SenderCredentials $senderCreds
     * @param Endpoint $endpoint
     * @return array
     */
    private function getConfig(SenderCredentials $senderCreds, Endpoint $endpoint)
    {
        $config = [
            'sender_id' => $senderCreds->getSenderId(),
            'sender_password' => $senderCreds->getPassword(),
            'control_id' => 'sessionProvider',
            'unique_id' => false,
            'dtd_version' => '3.0',
            'transaction' => false,
            'endpoint_url' => $endpoint->getEndpoint(),
            'verify_ssl' => $endpoint->getVerifySSL(),
            'no_retry_server_error_codes' => [], //retry all 500 level errors
        ];
        
        return $config;
    }

    /**
     * @param array $config
     * @return array
     */
    private function getAPISession(array $config)
    {
        $contentBlock = new Content();
        $getApiSession = new GetAPISession();
        $contentBlock->append($getApiSession);

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config);
        
        try {
            $client = $requestHandler->execute($requestBlock->getXml());
        } finally {
            $this->lastExecution = $requestHandler->getHistory();
        }
        
        $response = new SynchronousResponse($client->getBody()->getContents());
        
        $operation = $response->getOperation();
        $result = $operation->getResult(0);
        $data = $result->getData();
        $api = $data->api;

        $session = [
            'session_id' => strval($api->sessionid),
            'endpoint_url' => strval($api->endpoint),
            'verify_ssl' => $requestHandler->getVerifySSL(),
        ];
        
        return $session;
    }

    /**
     * @param LoginCredentials $loginCreds
     * @return SessionCredentials
     */
    public function fromLoginCredentials(LoginCredentials $loginCreds)
    {
        $senderCreds = $loginCreds->getSenderCredentials();
        $endpoint = $loginCreds->getEndpoint();
        $config = $this->getConfig($senderCreds, $endpoint);
        $config['company_id'] = $loginCreds->getCompanyId();
        $config['user_id'] = $loginCreds->getUserId();
        $config['user_password'] = $loginCreds->getPassword();
        $config['mock_handler'] = $loginCreds->getMockHandler();
        
        $session = $this->getAPISession($config);

        return new SessionCredentials($session, $senderCreds);
    }

    /**
     * @param SessionCredentials $sessionCreds
     * @return SessionCredentials
     */
    public function fromSessionCredentials(SessionCredentials $sessionCreds)
    {
        $senderCreds = $sessionCreds->getSenderCredentials();
        $endpoint = $sessionCreds->getEndpoint();
        $config = $this->getConfig($senderCreds, $endpoint);
        $config['session_id'] = $sessionCreds->getSessionId();
        $config['mock_handler'] = $sessionCreds->getMockHandler();
        
        $session = $this->getAPISession($config);

        return new SessionCredentials($session, $senderCreds);
    }

}
