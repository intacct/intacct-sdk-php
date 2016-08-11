<?php

/**
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
use GuzzleHttp\Handler\MockHandler;
use InvalidArgumentException;

class SessionCredentials
{

    /** @var string */
    private $sessionId;

    /** @var SenderCredentials */
    private $senderCreds;

    /** @var Endpoint */
    private $endpoint;

    /** @var string */
    private $currentCompanyId;

    /** @var string */
    private $currentUserId;

    /** @var bool */
    private $currentUserIsExternal;
    
    /** @var MockHandler */
    protected $mockHandler;

    /**
     * Initializes the class with the given parameters.
     *
     * The constructor accepts the following options:
     *
     * - `session_id` (string) Intacct session ID
     * - `endpoint_url` (string) Endpoint URL
     * - `current_company_id` (string) Current Intacct company ID
     * - `current_user_id` (string) Current Intacct user ID
     * - `current_user_is_external` (bool) Current Intacct user is external
     * - `mock_handler` (GuzzleHttp\Handler\MockHandler) Mock handler for unit tests
     *
     * @param array $params Client configuration options
     * @throws InvalidArgumentException
     *
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $endpoint_url Endpoint URL
     *      @var MockHandler $mock_handler Mock handler for unit testing
     *      @var string $session_id Intacct session ID
     * }
     * @param SenderCredentials $senderCreds Sender credentials
     */
    public function __construct(array $params, SenderCredentials $senderCreds)
    {
        $defaults = [
            'session_id' => null,
            'endpoint_url' => null,
            'mock_handler' => null,
            'current_company_id' => null,
            'current_user_id' => null,
            'current_user_is_external' => false,
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
        $this->currentCompanyId = $config['current_company_id'];
        $this->currentUserId = $config['current_user_id'];
        $this->currentUserIsExternal = $config['current_user_is_external'];
        $this->mockHandler = $config['mock_handler'];
    }

    /**
     * Get Intacct session ID
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Get endpoint
     *
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get sender credentials
     *
     * @return SenderCredentials
     */
    public function getSenderCredentials()
    {
        return $this->senderCreds;
    }

    /**
     * Get session's current company ID
     *
     * @return string
     */
    public function getCurrentCompanyId()
    {
        return $this->currentCompanyId;
    }

    /**
     * Get session's current user ID
     *
     * @return string
     */
    public function getCurrentUserId()
    {
        return $this->currentUserId;
    }

    /**
     * Get session's current user is external or not
     *
     * @return bool
     */
    public function getCurrentUserIsExternal()
    {
        return $this->currentUserIsExternal;
    }
    
    /**
     * Get mock handler for unit testing
     *
     * @return MockHandler
     */
    public function getMockHandler()
    {
        return $this->mockHandler;
    }
}
