<?php

/**
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

use InvalidArgumentException;

class ProfileCredentialProvider
{

    /** @var string */
    const DEFAULT_PROFILE_FILE = '/.intacct/credentials.ini';

    /** @var string */
    const DEFAULT_PROFILE_NAME = 'default';

    /**
     * Initializes the class
     */
    public function __construct()
    {
        //nothing to see here
    }
    
    /**
     * Get INI profile data with the given parameters.
     *
     * @param array $params {
     *      @var string $profile_file Profile file to load from
     *      @var string $profile_name Profile name to use
     * }
     * @return array
     */
    private function getIniProfileData(array $params = [])
    {
        $defaults = [
            'profile_name' => static::DEFAULT_PROFILE_NAME,
            'profile_file' => static::getHomeDirProfile(),
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['profile_name']) {
            throw new InvalidArgumentException(
                'Required "profile_name" key not supplied in params'
            );
        }
        if (!is_readable($config['profile_file'])) {
            throw new InvalidArgumentException(
                'Cannot read credentials from file, "' . $config['profile_file'] . '"'
            );
        }
        $data = parse_ini_file($config['profile_file'], true);
        if ($data === false) {
            throw new InvalidArgumentException(
                'Invalid credentials file, "' . $config['profile_file'] . '"'
            );
        }
        if (!isset($data[$config['profile_name']])) {
            throw new InvalidArgumentException(
                'Profile name "' . $config['profile_name'] . '" not found in credentials file'
            );
        }
        
        return $data[$config['profile_name']];
    }
    
    /**
     * Get Intacct login credentials with the given parameters.
     *
     * @param array $params {
     *      @var string $profile_file Profile file to load from
     *      @var string $profile_name Profile name to use
     * }
     * @return array
     */
    public function getLoginCredentials(array $params = [])
    {
        $data = $this->getIniProfileData($params);
        $loginCreds = [];
        
        if (isset($data['company_id'])) {
            $loginCreds['company_id'] = $data['company_id'];
        }
        if (isset($data['user_id'])) {
            $loginCreds['user_id'] = $data['user_id'];
        }
        if (isset($data['user_password'])) {
            $loginCreds['user_password'] = $data['user_password'];
        }
        
        return $loginCreds;
    }

    /**
     * Get Intacct sender credentials with the given parameters.
     *
     * @param array $params {
     *      @var string $profile_file Profile file to load from
     *      @var string $profile_name Profile name to use
     * }
     * @return array
     */
    public function getSenderCredentials(array $params = [])
    {
        $data = $this->getIniProfileData($params);
        $senderCreds = [];
        
        if (isset($data['sender_id'])) {
            $senderCreds['sender_id'] = $data['sender_id'];
        }
        if (isset($data['sender_password'])) {
            $senderCreds['sender_password'] = $data['sender_password'];
        }
        if (isset($data['endpoint_url'])) {
            $senderCreds['endpoint_url'] = $data['endpoint_url'];
        }
        
        return $senderCreds;
    }

    /**
     * Get home directory containing profile file
     *
     * @return string
     */
    private static function getHomeDirProfile()
    {
        $profile = null;
        
        $homeDir = getenv('HOME');
        
        if ($homeDir) { //Linux/Unix
            $profile = $homeDir . static::DEFAULT_PROFILE_FILE;
        } else { //Windows
            $homeDrive = getenv('HOMEDRIVE');
            $homePath = getenv('HOMEPATH');
            if ($homeDrive && $homePath) {
                $profile = $homeDrive . $homePath . static::DEFAULT_PROFILE_FILE;
            }
        }

        return $profile;
    }
}
