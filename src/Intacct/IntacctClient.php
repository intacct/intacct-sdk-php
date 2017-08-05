<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

use Intacct\Credentials\SessionCredentials;
use Intacct\Xml\AsynchronousResponse;
use Intacct\Xml\SynchronousResponse;

class IntacctClient extends AbstractClient
{

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
        parent::__construct($params);
    }

    /**
     * Session credentials
     *
     * @return SessionCredentials
     */
    public function getSessionCreds()
    {
        return parent::getSessionCreds();
    }

    /**
     * Execute a synchronous request to the API
     *
     * @param Content $contentBlock Content block to send
     * @param bool $transaction Force the operation to be one transaction
     * @param string $requestControlId Request control ID
     * @param bool $uniqueFunctionControlIds Force the function control ID's to be unique
     * @param array $params Overriding params, @see IntacctClient::__construct()
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
        return parent::execute(
            $contentBlock,
            $transaction,
            $requestControlId,
            $uniqueFunctionControlIds,
            $params
        );
    }

    /**
     * Execute an asynchronous request to the API
     *
     * @param Content $contentBlock Content block to send
     * @param string $asyncPolicyId Intacct asynchronous policy ID
     * @param bool $transaction Force the operation to be one transaction
     * @param string $requestControlId Request control ID
     * @param bool $uniqueFunctionControlIds Force the function control ID's to be unique
     * @param array $params Overriding params, @see IntacctClient::__construct()
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
        return parent::executeAsync(
            $contentBlock,
            $asyncPolicyId,
            $transaction,
            $requestControlId,
            $uniqueFunctionControlIds,
            $params
        );
    }
}
