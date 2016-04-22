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

namespace Intacct;

use Intacct\Credentials\LoginCredentials;
use Intacct\Credentials\SenderCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Credentials\SessionProvider;
use Intacct\GeneralLedger\GeneralLedger;
use Intacct\Reporting\Reports;
use Intacct\Xml\RequestHandler;
use Intacct\Xml\Request\Operation\ContentBlock;
use Intacct\Xml\Request\Operation\Content\InstallApp;
use Intacct\Xml\Response\Operation;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use Intacct\Dimension\Dimensions;

class IntacctClient
{
    /**
     * @var string
     */
    const PROFILE_ENV_NAME = 'INTACCT_PROFILE';

    /**
     *
     * @var SessionCredentials 
     */
    private $sessionCreds;
    
    /**
     *
     * @var array
     */
    private $lastExecution = [];

    /**
     * The constructor accepts the following options:
     *
     * - company_id: (string)
     * - endpoint_url: (string)
     * - profile_file: (string)
     * - profile_name: (string)
     * - sender_id: (string)
     * - sender_password: (string)
     * - session_id: (string, required)
     * - user_id: (string)
     * - user_password: (string)
     * - verify_ssl: (bool, default=bool(true))
     *
     * @param array $params
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

        try {
            if ($config['session_id']) {
                $sessionCreds = new SessionCredentials($config, $senderCreds);

                $this->sessionCreds = $provider->fromSessionCredentials($sessionCreds);
            } else {
                $loginCreds = new LoginCredentials($config, $senderCreds);

                $this->sessionCreds = $provider->fromLoginCredentials($loginCreds);
            }
        } finally {
            $this->lastExecution = $provider->getLastExecution();
        }

        $this->dimensions = new Dimensions($this);
        $this->generalLedger = new GeneralLedger($this);
        $this->reports = new Reports($this);
        $this->user = new User($this);
    }
    
    /**
     * 
     * @return SessionCredentials
     */
    private function getSessionCreds()
    {
        return $this->sessionCreds;
    }
    
    /**
     * 
     * @return array
     */
    public function getSessionConfig()
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
        ];
        
        return $config;
    }

    /**
     * Returns an array of the last execution's requests and responses.
     *
     * The array returned by this method can be used to generate appropriate
     * logging based on various exceptions and events.  This contains sensitive
     * data and should only be logged with due care.
     *
     * @return array
     */
    public function getLastExecution()
    {
        return $this->lastExecution;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - xml_filename: (string)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function installApp(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);

        $contentBlock = new ContentBlock([
            new InstallApp($params)
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $contentBlock);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to install platform app', $result->getErrors()
            );
        }

        return $result;
    }

}
