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
use Intacct\Credentials\ProfileCredentialProvider;
use InvalidArgumentException;

class SenderCredentials
{
    
    /**
     * @var string
     */
    const SENDER_PROFILE_ENV_NAME = 'INTACCT_SENDER_PROFILE';
    
    /**
     * @var string
     */
    const SENDER_ID_ENV_NAME = 'INTACCT_SENDER_ID';

    /**
     * @var string
     */
    const SENDER_PASSWORD_ENV_NAME = 'INTACCT_SENDER_PASSWORD';
    
    /**
     * @var string
     */
    const DEFAULT_SENDER_PROFILE = 'default';
    
    /**
     *
     * @var string
     */
    private $senderId;
    
    /**
     *
     * @var string
     */
    private $password;
    
    /**
     *
     * @var Endpoint
     */
    private $endpoint;

    /**
     * 
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'profile_name' => getenv(static::SENDER_PROFILE_ENV_NAME) ? getenv(static::SENDER_PROFILE_ENV_NAME) : static::DEFAULT_SENDER_PROFILE,
            'sender_id' => getenv(static::SENDER_ID_ENV_NAME),
            'sender_password' => getenv(static::SENDER_PASSWORD_ENV_NAME),
            'endpoint_url' => null,
            'verify_ssl' => true,
        ];
        $config = array_merge($defaults, $params);
        
        if (
                !$config['sender_id'] &&
                !$config['sender_password'] &&
                $config['profile_name']
        ) {
            $profileProvider = new ProfileCredentialProvider();
            $profileCreds = $profileProvider->getSenderCredentials($config);
            if ($config['endpoint_url'] && isset($profileCreds['endpoint_url'])) {
                //stop overwriting the endpoint_url if it was passed in already
                unset($profileCreds['endpoint_url']);
            }
            $config = array_merge($config, $profileCreds);
        }
        
        if (!$config['sender_id']) {
            throw new InvalidArgumentException(
                'Required "sender_id" key not supplied in params or env variable "' . static::SENDER_ID_ENV_NAME . '"'
            );
        }
        if (!$config['sender_password']) {
            throw new InvalidArgumentException(
                'Required "sender_password" key not supplied in params or env variable "' . static::SENDER_PASSWORD_ENV_NAME . '"'
            );
        }
        
        $this->senderId = $config['sender_id'];
        $this->password = $config['sender_password'];
        $this->endpoint = new Endpoint($config);
    }

    /**
     * 
     * @return string
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * 
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

}
