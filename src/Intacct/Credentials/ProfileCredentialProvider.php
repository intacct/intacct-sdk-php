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

class ProfileCredentialProvider
{

    /** @var string */
    const DEFAULT_PROFILE_FILE = '/.intacct/credentials.ini';

    /** @var string */
    const DEFAULT_PROFILE_NAME = 'default';

    /**
     * @param ClientConfig $config
     * @return ClientConfig
     */
    public static function getLoginCredentials(ClientConfig $config): ClientConfig
    {
        $creds = new ClientConfig();
        $data = static::getIniProfileData($config);
        
        if (isset($data['company_id'])) {
            $creds->setCompanyId($data['company_id']);
        }
        if (isset($data['entity_id'])) {
            $creds->setEntityId($data['entity_id']);
        }
        if (isset($data['user_id'])) {
            $creds->setUserId($data['user_id']);
        }
        if (isset($data['user_password'])) {
            $creds->setUserPassword($data['user_password']);
        }
        
        return $creds;
    }

    /**
     * @param ClientConfig $config
     * @return ClientConfig
     */
    public static function getSenderCredentials(ClientConfig $config): ClientConfig
    {
        $creds = new ClientConfig();
        $data = static::getIniProfileData($config);
        
        if (isset($data['sender_id'])) {
            $creds->setSenderId($data['sender_id']);
        }
        if (isset($data['sender_password'])) {
            $creds->setSenderPassword($data['sender_password']);
        }
        if (isset($data['endpoint_url'])) {
            $creds->setEndpointUrl($data['endpoint_url']);
        }
        
        return $creds;
    }

    /**
     * Get home directory containing profile file
     *
     * @return string
     */
    public static function getHomeDirProfile(): string
    {
        $profile = '';
        $homeDir = getenv('HOME');
        
        if ($homeDir) {
            //Linux/Unix
            $profile = $homeDir . static::DEFAULT_PROFILE_FILE;
        } else {
            //Windows
            $homeDrive = getenv('HOMEDRIVE');
            $homePath = getenv('HOMEPATH');
            if ($homeDrive && $homePath) {
                $profile = $homeDrive . $homePath . static::DEFAULT_PROFILE_FILE;
            }
        }

        return $profile;
    }

    /**
     * @param ClientConfig $config
     * @return array
     */
    private static function getIniProfileData(ClientConfig $config): array
    {
        if (!$config->getProfileName()) {
            $config->setProfileName(static::DEFAULT_PROFILE_NAME);
        }
        if (!$config->getProfileFile()) {
            $config->setProfileFile(static::getHomeDirProfile());
        }

        if (!is_readable($config->getProfileFile())) {
            throw new \InvalidArgumentException(
                'Cannot read credentials from file, "' . $config->getProfileFile() . '"'
            );
        }
        $data = parse_ini_file($config->getProfileFile(), true);
        if ($data === false) {
            throw new \InvalidArgumentException(
                'Invalid credentials file, "' . $config->getProfileFile() . '"'
            );
        }
        if (!isset($data[$config->getProfileName()])) {
            throw new \InvalidArgumentException(
                'Profile Name "' . $config->getProfileName() . '" not found in credentials file'
            );
        }

        return $data[$config->getProfileName()];
    }
}
