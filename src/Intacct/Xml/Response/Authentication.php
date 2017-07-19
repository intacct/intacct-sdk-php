<?php

/**
 * Copyright 2017 Intacct Corporation.
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

use Intacct\Exception\IntacctException;

class Authentication
{

    /** @var string */
    private $status;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    private function setStatus(string $status)
    {
        $this->status = $status;
    }

    /** @var string */
    private $userId;

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
    private function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    /** @var string */
    private $companyId;

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
    private function setCompanyId(string $companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * Authentication constructor.
     *
     * @param \SimpleXMLElement $authentication
     */
    public function __construct(\SimpleXMLElement $authentication)
    {
        if (!isset($authentication->status)) {
            throw new IntacctException('Authentication block is missing status element');
        }
        if (!isset($authentication->userid)) {
            throw new IntacctException('Authentication block is missing userid element');
        }
        if (!isset($authentication->companyid)) {
            throw new IntacctException('Authentication block is missing companyid element');
        }

        $this->setStatus(strval($authentication->status));
        $this->setUserId(strval($authentication->userid));
        $this->setCompanyId(strval($authentication->companyid));
        
        //TODO add getter/setter for elements: clientstatus, clientid, locationid, sessiontimestamp
    }
}
