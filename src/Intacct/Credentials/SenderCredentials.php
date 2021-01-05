<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

use Intacct\ClientConfig;

class SenderCredentials
{
    
    /** @var string */
    const SENDER_PROFILE_ENV_NAME = 'INTACCT_SENDER_PROFILE';
    
    /** @var string */
    const SENDER_ID_ENV_NAME = 'INTACCT_SENDER_ID';

    /** @var string */
    const SENDER_PASSWORD_ENV_NAME = 'INTACCT_SENDER_PASSWORD';
    
    /** @var string */
    const DEFAULT_SENDER_PROFILE = 'default';
    
    /** @var string */
    private $senderId;
    
    /** @var string */
    private $password;
    
    /** @var Endpoint */
    private $endpoint;

    public function __construct(ClientConfig $config)
    {
        $envProfileName = getenv(static::SENDER_PROFILE_ENV_NAME)
            ? getenv(static::SENDER_PROFILE_ENV_NAME)
            : static::DEFAULT_SENDER_PROFILE;

        if (!$config->getProfileName()) {
            $config->setProfileName($envProfileName);
        }
        if (!$config->getSenderId()) {
            $config->setSenderId(getenv(static::SENDER_ID_ENV_NAME));
        }
        if (!$config->getSenderPassword()) {
            $config->setSenderPassword(getenv(static::SENDER_PASSWORD_ENV_NAME));
        }

        if (
            !$config->getSenderId()
            && !$config->getSenderPassword()
            && $config->getProfileName()
        ) {
            $profile = ProfileCredentialProvider::getSenderCredentials($config);

            if ($profile->getSenderId()) {
                $config->setSenderId($profile->getSenderId());
            }
            if ($profile->getSenderPassword()) {
                $config->setSenderPassword($profile->getSenderPassword());
            }
            if (!$config->getEndpointUrl()) {
                // Only set the endpoint URL if it was never passed in to begin with
                $config->setEndpointUrl($profile->getEndpointUrl());
            }
        }
        
        if (!$config->getSenderId()) {
            throw new \InvalidArgumentException(
                'Required Sender ID not supplied in config or env variable "'
                . static::SENDER_ID_ENV_NAME . '"'
            );
        }
        if (!$config->getSenderPassword()) {
            throw new \InvalidArgumentException(
                'Required Sender Password not supplied in config or env variable "'
                . static::SENDER_PASSWORD_ENV_NAME . '"'
            );
        }
        
        $this->setSenderId($config->getSenderId());
        $this->setPassword($config->getSenderPassword());
        $this->setEndpoint(new Endpoint($config));
    }

    /**
     * @return string
     */
    public function getSenderId(): string
    {
        return $this->senderId;
    }

    /**
     * @param string $senderId
     */
    public function setSenderId(string $senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    /**
     * @param Endpoint $endpoint
     */
    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
