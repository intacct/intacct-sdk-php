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

use Intacct\Credentials\LoginCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Xml\Request\Operation\Content;
use Intacct\Xml\Request\Operation\Content\GetAPISession;
use Intacct\Xml\Request;
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
    
    private function getAPISession(array $config)
    {
        $content = new Content();
        $getApiSession = new GetAPISession();
        $content->append($getApiSession);
        
        $request = new Request($config, $content);
        
        try {
            $client = $request->execute();
        } finally {
            $this->lastExecution = $request->getHistory();
        }
        
        $response = new SynchronousResponse($client->getBody());
        
        $operation = $response->getOperation();
        $results = $operation->getResults();
        $result = $results[0];
        $data = $result->getData();
        $api = $data->api;

        $session = [
            'session_id' => strval($api->sessionid),
            'endpoint_url' => strval($api->endpoint),
            'verify_ssl' => $request->getVerifySSL(),
        ];
        
        return $session;
    }

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
