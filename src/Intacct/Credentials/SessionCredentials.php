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

class SessionCredentials implements CredentialsInterface
{

    /** @var string */
    private $sessionId;

    /** @var Endpoint */
    private $endpoint;

    /** @var SenderCredentials */
    private $senderCredentials;

    /**
     * SessionCredentials constructor.
     *
     * @param ClientConfig $config
     * @param SenderCredentials $senderCreds
     */
    public function __construct(ClientConfig $config, SenderCredentials $senderCreds)
    {
        if (!$config->getSessionId()) {
            throw new \InvalidArgumentException(
                'Required Session ID not supplied in config'
            );
        }
        
        $this->setSessionId($config->getSessionId());

        if ($config->getEndpointUrl()) {
            $this->setEndpoint(new Endpoint($config));
        } else {
            $this->setEndpoint($senderCreds->getEndpoint());
        }
        $this->setSenderCredentials($senderCreds);
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
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

    /**
     * @return SenderCredentials
     */
    public function getSenderCredentials(): SenderCredentials
    {
        return $this->senderCredentials;
    }

    /**
     * @param SenderCredentials $senderCredentials
     */
    public function setSenderCredentials(SenderCredentials $senderCredentials)
    {
        $this->senderCredentials = $senderCredentials;
    }
}
