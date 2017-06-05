<?php

/**
 * Copyright 2017 Intacct Corporation.
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
use Intacct\Functions\FunctionInterface;
use Intacct\Xml\AsynchronousResponse;
use Intacct\Xml\RequestHandler;
use Intacct\Xml\SynchronousResponse;
use Ramsey\Uuid\Uuid;

abstract class AbstractClient
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
    protected $sessionCreds;

    /**
     * Initializes the class with the given parameters.
     *
     * The constructor accepts the following options:
     *
     * - `profile_name` (string, default=string "default") Profile name to use
     * - `profile_file` (string) Profile file to load from
     * - `sender_id` (string) Intacct sender ID
     * - `sender_password` (string) Intacct sender password
     * - `session_id` (string) Intacct session ID
     * - `endpoint_url` (string) Endpoint URL
     * - `company_id` (string) Intacct company ID
     * - `user_id` (string) Intacct user ID
     * - `user_password` (string) Intacct user password
     * - `max_retries` (int, default=int(5)) Max number of retries
     * - `no_retry_server_error_codes` (int[], default=array(524)) HTTP server error codes to abort
     * retrying if one occurs
     * - `verify_ssl` (bool, default=bool(true)) Verify SSL certificate of response
     * - `logger` (Psr\Log\LoggerInterface)
     * - `log_formatter` (Intacct\Logging\MessageFormatter) Log formatter
     * - `log_level` (int, default=int(400)) Log level
     * - `mock_handler` (GuzzleHttp\Handler\MockHandler) Mock handler for unit tests
     *
     * @param array $params Client configuration options
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

        if ($config['session_id']) {
            $sessionCreds = new SessionCredentials($config, $senderCreds);

            $this->sessionCreds = $provider->fromSessionCredentials($sessionCreds);
        } else {
            $loginCreds = new LoginCredentials($config, $senderCreds);

            $this->sessionCreds = $provider->fromLoginCredentials($loginCreds);
        }
    }

    /**
     * Session credentials
     *
     * @return SessionCredentials
     */
    protected function getSessionCreds()
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
            'logger' => $sessionCreds->getLogger(),
            'log_formatter' => $sessionCreds->getLogMessageFormat(),
            'log_level' => $sessionCreds->getLogLevel(),
        ];

        return $config;
    }

    /**
     * Generate a version 4 (random) UUID
     *
     * @return string
     */
    public function generateRandomControlId()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * Execute a synchronous request to the API
     *
     * @param FunctionInterface[] $contentBlock Content block to send
     * @param bool $transaction Force the operation to be one transaction
     * @param string $requestControlId Request control ID
     * @param bool $uniqueFunctionControlIds Force the function control ID's to be unique
     * @param array $params Overriding params, @see IntacctClient::__construct()
     *
     * @return SynchronousResponse
     */
    protected function execute(
        array $contentBlock,
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

        $response = $requestHandler->executeSynchronous($config, $contentBlock);

        return $response;
    }

    /**
     * Execute an asynchronous request to the API
     *
     * @param FunctionInterface[] $contentBlock Content block to send
     * @param string $asyncPolicyId Intacct asynchronous policy ID
     * @param bool $transaction Force the operation to be one transaction
     * @param string $requestControlId Request control ID
     * @param bool $uniqueFunctionControlIds Force the function control ID's to be unique
     * @param array $params Overriding params, @see IntacctClient::__construct()
     *
     * @return AsynchronousResponse
     */
    protected function executeAsync(
        array $contentBlock,
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

        $response = $requestHandler->executeAsynchronous($config, $contentBlock);

        return $response;
    }
}
