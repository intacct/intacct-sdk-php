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
use Intacct\Xml\RequestHandler;
use Intacct\Xml\Request\Operation\Content;
use Intacct\Xml\Request\Operation\Content\GetUserPermissions;
use Intacct\Xml\Request\Operation\Content\InstallApp;
use Intacct\Xml\Request\Operation\Content\ReadMore;
use Intacct\Xml\Request\Operation\Content\ReadRelated;
use Intacct\Xml\Request\Operation\Content\ReadReport;
use Intacct\Xml\Request\Operation\Content\ReadView;
use Intacct\Xml\Response\Operation;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use Intacct\Dimension\Dimensions;
use ArrayIterator;

class IntacctClient
{
    /**
     * @var int
     */
    const MAX_QUERY_TOTAL_COUNT = 100000;

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
     * - page_size: (int, default=int(1000)
     * - return_format: (string, default=string(3) "xml")
     * - view: (string, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readView(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new ReadView($params),
        ]);

        $requestHandler = new RequestHandler($config);

        $operation = $requestHandler->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException('An error occurred trying to read view records', $result->getErrors());
        }
        
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     * @todo Finish this function, it's missing stuff and messy
     */
    public function readReport(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new ReadReport($params),
        ]);

        $requestHandler = new RequestHandler($config);

        $operation = $requestHandler->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException('An error occurred trying to read report records', $result->getErrors());
        }
        
        return $result;
    }

    /**
     * 
     * @param array $params
     * @return ArrayIterator
     * @throws ResultException
     */
    public function getViewRecords(array $params)
    {
        $defaults = [
            'max_total_count' => static::MAX_QUERY_TOTAL_COUNT,
        ];
        $config = array_merge($defaults, $params);
        
        $result = $this->readView($config);
        
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get view records', $result->getErrors()
            );
        }
        
        $records = new ArrayIterator();
        foreach ($result->getDataArray(true) as $record) {
            $records->append($record);
        }
        
        $totalCount = (int) strval($result->getData()->attributes()->totalcount);
        if ($totalCount > $config['max_total_count']) {
            throw new ResultException(
                'Query result totalcount exceeds max_total_count parameter of ' . $config['max_total_count']
            );
        }
        $numRemaining = (int) strval($result->getData()->attributes()->numremaining);
        if ($numRemaining > 0) {
            $pages = ceil($numRemaining / $config['page_size']);
            $resultId = $result->getData()->attributes()->resultId;
            $config['result_id'] = $resultId;
            for ($page = 1; $page <= $pages; $page++) {
                $readMore = $this->readMore($config);
                
                //append the readMore records to the original array
                foreach ($readMore->getDataArray(true) as $record) {
                    $records->append($record);
                }
            }
        }
        
        return $records;
    }
    
    /**
     * 
     * @param array $params
     * @return ArrayIterator
     * @throws ResultException
     * @todo this function is not finished yet to support report runtimes
     */
    public function getReportRecords(array $params)
    {
        $defaults = [
            'max_total_count' => static::MAX_QUERY_TOTAL_COUNT,
        ];
        $config = array_merge($defaults, $params);
        
        $result = $this->readReport($config);
        
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get report records', $result->getErrors()
            );
        }
        
        $records = new ArrayIterator();
        //TODO check if readReport nested or not
        foreach ($result->getDataArray(true) as $record) {
            $records->append($record);
        }
        
        $totalCount = (int) strval($result->getData()->attributes()->totalcount);
        if ($totalCount > $config['max_total_count']) {
            throw new ResultException(
                'Query result totalcount exceeds max_total_count parameter of ' . $config['max_total_count']
            );
        }
        $numRemaining = (int) strval($result->getData()->attributes()->numremaining);
        if ($numRemaining > 0) {
            $pages = ceil($numRemaining / $config['page_size']);
            $resultId = $result->getData()->attributes()->resultId;
            $config['result_id'] = $resultId;
            for ($page = 1; $page <= $pages; $page++) {
                $readMore = $this->readMore($config);
                
                //append the readMore records to the original array
                //TODO check if readReport nested or not
                foreach ($readMore->getDataArray(true) as $record) {
                    $records->append($record);
                }
            }
        }
        
        return $records;
    }
    
    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - result_id: (string, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readMore(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);

        $content = new Content([
            new ReadMore($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read more records', $result->getErrors()
            );
        }
        
        return $result;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - fields: (array)
     * - keys: (array)
     * - object: (string, required)
     * - relation: (string, required)
     * - return_format: (string, default=string(3) "xml")
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readRelated(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new ReadRelated($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read related records', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - user_id: (string, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function getUserPermissions(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new GetUserPermissions($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get user permissions', $result->getErrors()
            );
        }
        
        return $result;
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

        $content = new Content([
            new InstallApp($params)
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to install platform app', $result->getErrors()
            );
        }

        return $result;
    }

}
