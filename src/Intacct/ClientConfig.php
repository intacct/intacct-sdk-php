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

namespace Intacct;

use GuzzleHttp\Handler\MockHandler;
use Intacct\Credentials\CredentialsInterface;
use Intacct\Logging\MessageFormatter;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class ClientConfig
{

    /** @var string */
    private $profileFile = '';

    /**
     * @return string
     */
    public function getProfileFile(): string
    {
        return $this->profileFile;
    }

    /**
     * @param string $profileFile
     */
    public function setProfileFile(string $profileFile)
    {
        $this->profileFile = $profileFile;
    }

    /** @var string */
    private $profileName = '';

    /**
     * @return string
     */
    public function getProfileName(): string
    {
        return $this->profileName;
    }

    /**
     * @param string $profileName
     */
    public function setProfileName(string $profileName)
    {
        $this->profileName = $profileName;
    }

    /** @var string */
    private $endpointUrl = '';

    /**
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return $this->endpointUrl;
    }

    /**
     * @param string $endpointUrl
     */
    public function setEndpointUrl(string $endpointUrl)
    {
        $this->endpointUrl = $endpointUrl;
    }

    /** @var string */
    private $senderId = '';

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

    /** @var string */
    private $senderPassword = '';

    /**
     * @return string
     */
    public function getSenderPassword(): string
    {
        return $this->senderPassword;
    }

    /**
     * @param string $senderPassword
     */
    public function setSenderPassword(string $senderPassword)
    {
        $this->senderPassword = $senderPassword;
    }

    /** @var string */
    private $sessionId = '';

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

    /** @var string */
    private $sessionTimestamp = '';

    /**
     * @return string
     */
    public function getSessionTimestamp(): string
    {
        return $this->sessionTimestamp;
    }

    /**
     * @param string $sessionTimestamp
     */
    public function setSessionTimestamp(string $sessionTimestamp): void
    {
        $this->sessionTimestamp = $sessionTimestamp;
    }

    /** @var string */
    private $sessionTimeout = '';

    /**
     * @return string
     */
    public function getSessionTimeout(): string
    {
        return $this->sessionTimeout;
    }

    /**
     * @param string $sessionTimeout
     */
    public function setSessionTimeout(string $sessionTimeout): void
    {
        $this->sessionTimeout = $sessionTimeout;
    }

    /** @var string */
    private $companyId = '';

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId(string $companyId)
    {
        $this->companyId = $companyId;
    }

    /** @var string|null */
    private $entityId;

    /**
     * @return string|null
     */
    public function getEntityId() //:string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId(string $entityId)
    {
        $this->entityId = $entityId;
    }

    /** @var string */
    private $userId = '';

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    /** @var string */
    private $userPassword = '';

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     */
    public function setUserPassword(string $userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /** @var CredentialsInterface */
    private $credentials;

    /**
     * @return CredentialsInterface
     */
    public function getCredentials() //: CredentialsInterface PHP 7.0 does not support nullables
    {
        return $this->credentials;
    }

    /**
     * @param CredentialsInterface $credentials
     */
    public function setCredentials(CredentialsInterface $credentials)
    {
        $this->credentials = $credentials;
    }

    /** @var LoggerInterface */
    private $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger() //: LoggerInterface PHP 7.0 does not support nullables
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /** @var string */
    private $logLevel;

    /**
     * @return string
     */
    public function getLogLevel(): string
    {
        return $this->logLevel;
    }

    /**
     * @param string $logLevel
     */
    public function setLogLevel(string $logLevel)
    {
        $this->logLevel = $logLevel;
    }

    /** @var MessageFormatter */
    private $logMessageFormatter;

    /**
     * @return MessageFormatter
     */
    public function getLogMessageFormatter(): MessageFormatter
    {
        return $this->logMessageFormatter;
    }

    /**
     * @param MessageFormatter $logMessageFormatter
     */
    public function setLogMessageFormatter(MessageFormatter $logMessageFormatter)
    {
        $this->logMessageFormatter = $logMessageFormatter;
    }

    /** @var MockHandler */
    private $mockHandler;

    /**
     * @return MockHandler
     */
    public function getMockHandler()
    {
        return $this->mockHandler;
    }

    /**
     * @param MockHandler $mockHandler
     */
    public function setMockHandler(MockHandler $mockHandler)
    {
        $this->mockHandler = $mockHandler;
    }

    /**
     * ClientConfig constructor.
     */
    public function __construct()
    {
        $this->setLogLevel(LogLevel::DEBUG);
        $this->setLogMessageFormatter(new MessageFormatter());
    }
}
