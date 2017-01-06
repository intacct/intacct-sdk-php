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

namespace Intacct\Credentials;

use GuzzleHttp\Handler\MockHandler;
use InvalidArgumentException;
use Intacct\Endpoint;

class LoginCredentials
{
    
    /** @var string */
    const COMPANY_PROFILE_ENV_NAME = 'INTACCT_COMPANY_PROFILE';
    
    /** @var string */
    const COMPANY_ID_ENV_NAME = 'INTACCT_COMPANY_ID';

    /** @var string */
    const USER_ID_ENV_NAME = 'INTACCT_USER_ID';

    /** @var string */
    const USER_PASSWORD_ENV_NAME = 'INTACCT_USER_PASSWORD';
    
    /** @var string */
    const DEFAULT_COMPANY_PROFILE = 'default';

    /** @var string */
    private $companyId;

    /** @var string */
    private $userId;

    /** @var string */
    private $password;

    /** @var SenderCredentials */
    private $senderCreds;
    
    /** @var MockHandler */
    protected $mockHandler;

    /**
     * Initializes the class with the given parameters.
     *
     * The constructor accepts the following options:
     *
     * - `profile_name` (string, default=string "default") Profile name to use
     * - `profile_file` (string) Profile file to load from
     * - `company_id` (string) Intacct company ID
     * - `user_id` (string) Intacct user ID
     * - `user_password` (string) Intacct user password
     * - `mock_handler` (GuzzleHttp\Handler\MockHandler) Mock handler for unit tests
     *
     * @param array $params Login Credentials configuration options
     * @param SenderCredentials $senderCreds
     * @throws InvalidArgumentException
     */
    public function __construct(array $params, SenderCredentials $senderCreds)
    {
        $defaults = [
            'profile_name' => getenv(static::COMPANY_PROFILE_ENV_NAME)
                ? getenv(static::COMPANY_PROFILE_ENV_NAME)
                : static::DEFAULT_COMPANY_PROFILE,
            'company_id' => getenv(static::COMPANY_ID_ENV_NAME),
            'user_id' => getenv(static::USER_ID_ENV_NAME),
            'user_password' => getenv(static::USER_PASSWORD_ENV_NAME),
            'mock_handler' => null,
        ];
        $config = array_merge($defaults, $params);

        if (!$config['company_id'] && !$config['user_id'] && !$config['user_password'] && $config['profile_name']) {
            $profileProvider = new ProfileCredentialProvider();
            $profileCreds = $profileProvider->getLoginCredentials($config);
            $config = array_merge($config, $profileCreds);
        }

        if (!$config['company_id']) {
            throw new InvalidArgumentException(
                'Required "company_id" key not supplied in params or env variable "'
                . static::COMPANY_ID_ENV_NAME . '"'
            );
        }
        if (!$config['user_id']) {
            throw new InvalidArgumentException(
                'Required "user_id" key not supplied in params or env variable "'
                . static::USER_ID_ENV_NAME . '"'
            );
        }
        if (!$config['user_password']) {
            throw new InvalidArgumentException(
                'Required "user_password" key not supplied in params or env variable "'
                . static::USER_PASSWORD_ENV_NAME . '"'
            );
        }

        $this->companyId = $config['company_id'];
        $this->userId = $config['user_id'];
        $this->password = $config['user_password'];
        $this->senderCreds = $senderCreds;
        $this->mockHandler = $config['mock_handler'];
    }

    /**
     * Get Intacct company ID
     *
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Get Intacct user ID
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get Intacct user password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
     * Get endpoint
     *
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->senderCreds->getEndpoint();
    }
    
    /**
     * Get mock handler for unit tests
     *
     * @return MockHandler
     */
    public function getMockHandler()
    {
        return $this->mockHandler;
    }
}
