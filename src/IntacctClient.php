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

use Intacct\Credentials\LoginCredentials;
use Intacct\Credentials\SenderCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Credentials\SessionProvider;
use Intacct\Xml\AsynchronousResponse;
use Intacct\Xml\RequestHandler;
use Intacct\Xml\SynchronousResponse;
use Intacct\Content;
use Intacct\Xml\Response\Operation\Result;
use Ramsey\Uuid\Uuid;

class IntacctClient implements IntacctClientInterface
{

    /**
     * @var string
     */
    const PROFILE_ENV_NAME = 'INTACCT_PROFILE';

    /**
     *
     * @var SessionCredentials
     */
    private $sessionCreds;

    /**
     *
     * @var array
     */
    private $lastExecution = [];

    /**
     * The constructor accepts the following options:
     *
     * - company_id: (string)
     * - endpoint_url: (string)
     * - logger: (LoggerInterface)
     * - log_formatter: (MessageFormatter)
     * - log_level: (int, default=int(400))
     * - profile_file: (string)
     * - profile_name: (string)
     * - sender_id: (string)
     * - sender_password: (string)
     * - session_id: (string)
     * - user_id: (string)
     * - user_password: (string)
     * - verify_ssl: (bool, default=bool(true))
     *
     * @param array $params
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
     *
     * @return SessionCredentials
     */
    private function getSessionCreds()
    {
        return $this->sessionCreds;
    }

    /**
     *
     * @return array
     */
    public function getSessionConfig()
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
     * Returns an array of the last execution's requests and responses.
     *
     * The array returned by this method can be used to generate appropriate
     * logging based on various exceptions and events.  This contains sensitive
     * data and should only be logged with due care.
     *
     * @return array
     */
    public function getLastExecution()
    {
        return $this->lastExecution;
    }

    /**
     * @param Content $contentBlock
     * @param bool $transaction
     * @param string $requestControlId
     * @param bool $uniqueFunctionControlIds
     * @param array $params
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
     * @param Content $contentBlock
     * @param string $asyncPolicyId
     * @param bool $transaction
     * @param string $requestControlId
     * @param bool $uniqueFunctionControlIds
     * @param array $params
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