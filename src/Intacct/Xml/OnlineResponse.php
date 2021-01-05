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

namespace Intacct\Xml;

use Intacct\Exception\IntacctException;
use Intacct\Exception\ResponseException;
use Intacct\Xml\Response\Authentication;
use Intacct\Xml\Response\ErrorMessage;
use Intacct\Xml\Response\Result;

class OnlineResponse extends AbstractResponse
{

    /** @var Authentication */
    private $authentication;

    /**
     * @return Authentication
     */
    public function getAuthentication(): Authentication
    {
        return $this->authentication;
    }

    /**
     * @param Authentication $authentication
     */
    private function setAuthentication(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /** @var Result[] */
    private $results = [];

    /**
     * @return Result[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param Result[] $results
     */
    private function setResults(array $results)
    {
        $this->results = $results;
    }

    /**
     * @param int $key
     * @return Result
     */
    public function getResult($key = 0): Result
    {
        return $this->results[$key];
    }

    /**
     * @param Result $result
     */
    private function addResult(Result $result)
    {
        $this->results[] = $result;
    }

    /**
     * OnlineResponse constructor.
     *
     * @param string $body
     */
    public function __construct(string $body)
    {
        parent::__construct($body);
        if (!isset($this->getXml()->{'operation'})) {
            throw new IntacctException('Response is missing operation block');
        }

        if (!isset($this->getXml()->{'operation'}->{'authentication'})) {
            throw new IntacctException('Authentication block is missing from operation element');
        }
        $this->setAuthentication(new Authentication($this->getXml()->{'operation'}->{'authentication'}[0]));

        if ($this->getAuthentication()->getStatus() !== 'success') {
            $errors = [];
            if (isset($this->getXml()->{'operation'}->{'errormessage'})) {
                $errorMessage = new ErrorMessage($this->getXml()->{'operation'}->{'errormessage'});
                $errors = $errorMessage->getErrors();
            }
            throw new ResponseException('Response authentication status failure', $errors);
        }

        if (!isset($this->getXml()->{'operation'}->{'result'}[0])) {
            throw new IntacctException('Result block is missing from operation element');
        }

        foreach ($this->getXml()->{'operation'}->{'result'} as $result) {
            $this->addResult(new Result($result));
        }
    }
}
