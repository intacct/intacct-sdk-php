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

namespace Intacct;

use GuzzleHttp\MessageFormatter;
use Intacct\Credentials\LoginCredentials;
use Intacct\Credentials\SenderCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Credentials\SessionProvider;
use Intacct\Xml\AsynchronousResponse;
use Intacct\Xml\RequestHandler;
use Intacct\Xml\SynchronousResponse;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class IntacctClient
{

    /**
     * Profile environment name
     *
     * @var string
     */
    const PROFILE_ENV_NAME = 'INTACCT_PROFILE';

    /**
     * Session credentials
     *
     * @var SessionCredentials
     */
    private $sessionCreds;

    /**
     * Last execution
     *
     * @var array
     */
    private $lastExecution = [];

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $company_id Intacct company ID
     *      @var string $endpoint_url Endpoint URL
     *      @var LoggerInterface $logger
     *      @var MessageFormatter $log_formatter
     *      @var int $log_level Log level to use, default=400
     *      @var int $max_retries Max number of retries, default=5
     *      @var int[] $no_retry_server_error_codes HTTP server error codes to abort
     *          retrying if one occurs, default=[ 524 ]
     *      @var string $profile_file Profile file to load from
     *      @var string $profile_name Profile name to use
     *      @var string $sender_id Intacct sender ID
     *      @var string $sender_password Intacct sender password
     *      @var string $session_id Intacct session ID
     *      @var string $user_id Intacct user ID
     *      @var string $user_password Intacct user password
     *      @var bool $verify_ssl Verify SSL certificate of response, default=true
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'session_id' => null,
            'endpoint_url' => null,
            'verify_ssl' => true,
        ];
        $envProfile = getenv(static::PROFILE_ENV_NAME);
        if ($envProfile) {
            $defaults['profile_name'] = $envProfile;
        }
        $config = array_merge($defaults, $params);

        $provider = new SessionProvider();

        $senderCreds = new SenderCredentials($config);

        try {
            if ($config['session_id']) {
                $sessionCreds = new SessionCredentials($config, $senderCreds);

                $this->sessionCreds = $provider->fromSessionCredentials($sessionCreds);
            } else {
                $loginCreds = new LoginCredentials($config, $senderCreds);

                $this->sessionCreds = $provider->fromLoginCredentials($loginCreds);
            }
        } finally {
            $this->lastExecution = $provider->getLastExecution();
        }
    }

    /**
     * Session credentials
     *
     * @return SessionCredentials
     */
    public function getSessionCreds()
    {
        return $this->sessionCreds;
    }

    /**
     * Get session config array
     *
     * @return array
     */
    private function getSessionConfig()
    {
        $sessionCreds = $this->getSessionCreds();
        $senderCreds = $sessionCreds->getSenderCredentials();
        $endpoint = $sessionCreds->getEndpoint();

        $config = [
            'sender_id' => $senderCreds->getSenderId(),
            'sender_password' => $senderCreds->getPassword(),
            'endpoint_url' => $endpoint->getEndpoint(),
            'verify_ssl' => $endpoint->getVerifySSL(),
            'session_id' => $sessionCreds->getSessionId(),
        ];

        return $config;
    }

    /**
     * Generate a version 4 (random) UUID
     *
     * @return string
     */
    public function getRandomControlId()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * Get array of the last execution's requests and responses
     *
     * @return array
     */
    public function getLastExecution()
    {
        return $this->lastExecution;
    }

    /**
     * Execute a synchronous request to the API
     *
     * @param Content $contentBlock Content block to send
     * @param bool $transaction Force the operation to be one transaction
     * @param string $requestControlId Request control ID
     * @param bool $uniqueFunctionControlIds Force the function control ID's to be unique
     * @param array $params Overriding params @see IntacctClient::__construct() for these
     *
     * @return SynchronousResponse
     */
    public function execute(
        Content $contentBlock,
        $transaction = false,
        $requestControlId = null,
        $uniqueFunctionControlIds = false,
        array $params = []
    ) {
        $config = array_merge(
            $this->getSessionConfig(),
            [
                'transaction' => $transaction,
                'control_id' => $requestControlId,
                'unique_id' => $uniqueFunctionControlIds,
            ],
            $params
        );
        
        $requestHandler = new RequestHandler($config);

        try {
            $response = $requestHandler->executeSynchronous($config, $contentBlock);
        } finally {
            $this->lastExecution = $requestHandler->getHistory();
        }
        
        return $response;
    }

    /**
     * Execute an asynchronous request to the API
     *
     * @param Content $contentBlock Content block to send
     * @param string $asyncPolicyId Intacct asynchronous policy ID
     * @param bool $transaction Force the operation to be one transaction
     * @param string $requestControlId Request control ID
     * @param bool $uniqueFunctionControlIds Force the function control ID's to be unique
     * @param array $params Overriding params @see IntacctClient::__construct() for these
     *
     * @return AsynchronousResponse
     */
    public function executeAsync(
        Content $contentBlock,
        $asyncPolicyId,
        $transaction = false,
        $requestControlId = null,
        $uniqueFunctionControlIds = false,
        array $params = []
    ) {
        $config = array_merge(
            $this->getSessionConfig(),
            [
                'policy_id' => $asyncPolicyId,
                'transaction' => $transaction,
                'control_id' => $requestControlId,
                'unique_id' => $uniqueFunctionControlIds,
            ],
            $params
        );

        $requestHandler = new RequestHandler($config);

        try {
            $response = $requestHandler->executeAsynchronous($config, $contentBlock);
        } finally {
            $this->lastExecution = $requestHandler->getHistory();
        }

        return $response;
    }
}
