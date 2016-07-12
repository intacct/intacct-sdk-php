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

namespace Intacct\Xml\Response;

use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\Authentication;
use Intacct\Xml\Response\OperationException;
use Intacct\Xml\Response\ErrorMessage;
use Intacct\Exception;
use SimpleXMLIterator;

class Operation
{

    /**
     *
     * @var Authentication
     */
    private $authentication;

    /**
     *
     * @var array
     */
    private $results = [];

    public function __construct(SimpleXMLIterator $operation)
    {
        if (!isset($operation->authentication)) {
            throw new Exception('Authentication block is missing from operation element');
        }
        $this->setAuthentication($operation->authentication);

        if ($this->authentication->getStatus() !== 'success') {
            $errors = [];
            if (isset($operation->errormessage)) {
                $errorMessage = new ErrorMessage($operation->errormessage);
                $errors = $errorMessage->getErrors();
            }
            throw new OperationException('Response authentication status failure', $errors);
        }
        
        if (!isset($operation->result[0])) {
            throw new Exception('Result block is missing from operation element');
        }
        
        foreach ($operation->result as $result) {
            $this->setResult($result);
        }
    }

    private function setAuthentication(SimpleXMLIterator $authentication)
    {
        $this->authentication = new Authentication($authentication);
    }

    public function getAuthentication()
    {
        return $this->authentication;
    }

    private function setResult(SimpleXMLIterator $result)
    {
        $this->results[] = new Result($result);
    }
    
    /**
     *
     * @param int $key
     * @return Result
     */
    public function getResult($key = 0)
    {
        return $this->results[$key];
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }
}
