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

use Intacct\Endpoint;
use Intacct\Credentials\SenderCredentials;
use GuzzleHttp\Handler\MockHandler;
use InvalidArgumentException;

class SessionCredentials
{

    /**
     *
     * @var string
     */
    private $sessionId;

    /**
     *
     * @var SenderCredentials
     */
    private $senderCreds;

    /**
     *
     * @var Endpoint
     */
    private $endpoint;
    
    /**
     * 
     * @var MockHandler
     */
    protected $mockHandler;

    /**
     * 
     * @param array $params
     * @param SenderCredentials $senderCreds
     */
    public function __construct(array $params, SenderCredentials $senderCreds)
    {
        $defaults = [
            'session_id' => null,
            'endpoint_url' => null,
            'mock_handler' => null,
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['session_id']) {
            throw new InvalidArgumentException(
                    'Required "session_id" key not supplied in params'
            );
        }
        
        $this->sessionId = $config['session_id'];
        if ($config['endpoint_url']) {
            $this->endpoint = new Endpoint($config);
        } else {
            $this->endpoint = $senderCreds->getEndpoint();
        }
        $this->senderCreds = $senderCreds;
        $this->mockHandler = $config['mock_handler'];
    }

    /**
     * 
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * 
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * 
     * @return SenderCredentials
     */
    public function getSenderCredentials()
    {
        return $this->senderCreds;
    }
    
    /**
     * 
     * @return MockHandler
     */
    public function getMockHandler()
    {
        return $this->mockHandler;
    }

}
