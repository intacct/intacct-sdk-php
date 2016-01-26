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

use Intacct\Credentials\SenderCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Credentials\LoginCredentials;
use Intacct\Credentials\SessionProvider;
use Intacct\Xml\Request;
use Intacct\Xml\Request\Operation\Content;
use Intacct\Xml\Request\Operation\Content\GetUserPermissions;
use Intacct\Xml\Request\Operation\Content\Read;
use Intacct\Xml\Request\Operation\Content\ReadByName;
use Intacct\Xml\Request\Operation\Content\ReadByQuery;
use Intacct\Xml\Request\Operation\Content\ReadMore;
use Intacct\Xml\Request\Operation\Content\ReadRelated;
use Intacct\Xml\Request\Operation\Content\ReadView;
use Intacct\Xml\Request\Operation\Content\Implicit\Create;
use Intacct\Xml\Request\Operation\Content\Implicit\Update;
use Intacct\Xml\Request\Operation\Content\Implicit\Delete;
use Intacct\Xml\SynchronousResponse;
use Intacct\Xml\AsynchronousResponse;
use Intacct\Xml\Response\Acknowledgement;
use Intacct\Xml\Response\Operation;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use ArrayIterator;
use InvalidArgumentException;

class Sdk
{
    
    /**
     * @var string
     */
    const VERSION = '1.0';
    
    /**
     * @var int
     */
    const MAX_QUERY_TOTAL_COUNT = 100000;
    
    /**
     * @var int
     */
    const MAX_UPSERT_COUNT = 1000;
    
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
    }
    
    /**
     * 
     * @return SessionCredentials
     */
    public function getSessionCreds()
    {
        return $this->sessionCreds;
    }
    
    /**
     * 
     * @return array
     */
    public function getLastExecution()
    {
        return $this->lastExecution;
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
     * 
     * @param array $params
     * @param Content $content
     * @return Operation
     */
    public function executeContent(array $params, Content $content)
    {
        unset($params['policy_id']);
        $request = new Request($params, $content);
        
        try {
            $client = $request->execute();
        } finally {
            $this->lastExecution = $request->getHistory();
        }
        
        $response = new SynchronousResponse($client->getBody());
        
        return $response->getOperation();
    }
    
    /**
     * 
     * @param array $params
     * @param Content $content
     * @return Acknowledgement
     */
    public function executeContentAsync(array $params, Content $content)
    {
        $defaults = [
            'policy_id' => null,
        ];
        $config = array_merge($defaults, $params);
        
        if (!isset($params['policy_id'])) {
            throw new InvalidArgumentException(
                'Required "policy_id" key not supplied in params for asynchronous request'
            );
        }
        
        $request = new Request($config, $content);
        $client = $request->execute();
        $response = new AsynchronousResponse($client->getBody());
        
        return $response->getAcknowledgement();
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readByQuery(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new ReadByQuery($params),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException('An error occurred trying to read query records', $result->getErrors());
        }
        
        return $result;
    }
    
    /**
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
        $operation = $this->executeContent($config, $content);
        
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
        $operation = $this->executeContent($config, $content);
        
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
    public function getQueryRecords(array $params)
    {
        $defaults = [
            'max_total_count' => static::MAX_QUERY_TOTAL_COUNT,
        ];
        $session = $this->getSessionConfig();
        $config = array_merge($defaults, $session, $params);
        
        $result = $this->readByQuery($config);
        
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get query records', $result->getErrors()
            );
        }
        
        $records = new ArrayIterator();
        foreach ($result->getDataArray() as $record) {
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
                foreach ($readMore->getDataArray() as $record) {
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
     */
    public function getViewRecords(array $params)
    {
        $defaults = [
            'max_total_count' => static::MAX_QUERY_TOTAL_COUNT,
        ];
        $session = $this->getSessionConfig();
        $config = array_merge($defaults, $session, $params);
        
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
        $session = $this->getSessionConfig();
        $config = array_merge($defaults, $session, $params);
        
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
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readMore(array $params)
    {
        $content = new Content([
            new ReadMore($params),
        ]);
        $operation = $this->executeContent($params, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read more records', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function read(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new Read($config),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read records', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readByName(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new ReadByName($config),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read records by name', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
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
            new ReadRelated($config),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read related records', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
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
            new GetUserPermissions($config),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get user permissions', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function create(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new Create($params),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to create records', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function update(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new Update($params),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to update records', $result->getErrors()
            );
        }
        
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function delete(array $params)
    {
        $session = $this->getSessionConfig();
        $config = array_merge($session, $params);
        
        $content = new Content([
            new Delete($params),
        ]);
        $operation = $this->executeContent($config, $content);
        
        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to delete records', $result->getErrors()
            );
        }
        
        return $result;
    }

}
