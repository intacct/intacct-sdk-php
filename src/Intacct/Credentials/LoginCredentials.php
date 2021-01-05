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

class LoginCredentials implements CredentialsInterface
{
    
    /** @var string */
    const COMPANY_PROFILE_ENV_NAME = 'INTACCT_COMPANY_PROFILE';
    
    /** @var string */
    const COMPANY_ID_ENV_NAME = 'INTACCT_COMPANY_ID';

    /** @var string */
    const ENTITY_ID_ENV_NAME = 'INTACCT_ENTITY_ID';

    /** @var string */
    const USER_ID_ENV_NAME = 'INTACCT_USER_ID';

    /** @var string */
    const USER_PASSWORD_ENV_NAME = 'INTACCT_USER_PASSWORD';
    
    /** @var string */
    const DEFAULT_COMPANY_PROFILE = 'default';

    /** @var string */
    private $companyId;

    /** @var string|null */
    private $entityId;

    /** @var string */
    private $userId;

    /** @var string */
    private $password;

    /** @var SenderCredentials */
    private $senderCredentials;

    /**
     * LoginCredentials constructor.
     *
     * @param ClientConfig $config
     * @param SenderCredentials $senderCreds
     */
    public function __construct(ClientConfig $config, SenderCredentials $senderCreds)
    {
        $envProfileName = getenv(static::COMPANY_PROFILE_ENV_NAME) ?? static::DEFAULT_COMPANY_PROFILE;
        if (!$config->getProfileName()) {
            $config->setProfileName($envProfileName);
        }
        if (!$config->getCompanyId()) {
            $config->setCompanyId(getenv(static::COMPANY_ID_ENV_NAME));
        }
        if ($config->getEntityId() == null) {
            $envEntityId = getenv(static::ENTITY_ID_ENV_NAME);
            if ($envEntityId !== false) {
                $config->setEntityId($envEntityId);
            }
        }
        if (!$config->getUserId()) {
            $config->setUserId(getenv(static::USER_ID_ENV_NAME));
        }
        if (!$config->getUserPassword()) {
            $config->setUserPassword(getenv(static::USER_PASSWORD_ENV_NAME));
        }
        if (
            !$config->getCompanyId()
            && !$config->getUserId()
            && !$config->getUserPassword()
            && $config->getProfileName()
        ) {
            $profile = ProfileCredentialProvider::getLoginCredentials($config);

            if ($profile->getCompanyId()) {
                $config->setCompanyId($profile->getCompanyId());
            }
            if ($profile->getEntityId() !== null) {
                $config->setEntityId($profile->getEntityId());
            }
            if ($profile->getUserId()) {
                $config->setUserId($profile->getUserId());
            }
            if ($profile->getUserPassword()) {
                $config->setUserPassword($profile->getUserPassword());
            }
        }

        if (!$config->getCompanyId()) {
            throw new \InvalidArgumentException(
                'Required Company ID not supplied in config or env variable "'
                . static::COMPANY_ID_ENV_NAME . '"'
            );
        }
        // Entity ID is not required, no Error
        if (!$config->getUserId()) {
            throw new \InvalidArgumentException(
                'Required User ID not supplied in config or env variable "'
                . static::USER_ID_ENV_NAME . '"'
            );
        }
        if (!$config->getUserPassword()) {
            throw new \InvalidArgumentException(
                'Required User Password not supplied in config or env variable "'
                . static::USER_PASSWORD_ENV_NAME . '"'
            );
        }

        $this->setCompanyId($config->getCompanyId());
        if ($config->getEntityId() !== null) {
            $this->setEntityId($config->getEntityId());
        }
        $this->setUserId($config->getUserId());
        $this->setPassword($config->getUserPassword());
        $this->setSenderCredentials($senderCreds);
    }

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

    /**
     * @return string
     */
    public function getEntityId() //: string
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
