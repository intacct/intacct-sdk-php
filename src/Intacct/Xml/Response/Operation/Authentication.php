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

namespace Intacct\Xml\Response\Operation;

use Intacct\Exception\IntacctException;
use SimpleXMLIterator;

class Authentication
{

    /** @var string */
    private $status;

    /** @var string */
    private $userId;

    /** @var string */
    private $companyId;

    /** @var boolean */
    private $slideInUser;

    /**
     * Initializes the class
     *
     * @param SimpleXMLIterator $authentication
     * @throws IntacctException
     */
    public function __construct(SimpleXMLIterator $authentication)
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

        $this->status = strval($authentication->status);
        $this->userId = strval($authentication->userid);
        $this->companyId = strval($authentication->companyid);
        $this->setSlideInUser($this->userId);
        
        //TODO add getter/setter for elements: clientstatus, clientid, locationid, sessiontimestamp
    }

    /**
     * Get authentication status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get user ID
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get company ID
     *
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Get if user is external
     *
     * @return boolean
     */
    public function getSlideInUser()
    {
        return $this->slideInUser;
    }

    /**
     * Set if user is external
     *
     * @param string $userId
     */
    private function setSlideInUser($userId)
    {
        $slideInUser = false;
        if (strpos($userId, 'CPAUser') !== false) {
            $slideInUser = true;
        } elseif (strpos($userId, 'ExtUser|') !== false) {
            $slideInUser = true;
        } elseif (strpos($userId, 'SvcUser|') !== false) {
            $slideInUser = true;
        } elseif (strpos($userId, 'intacct') !== false) {
            $slideInUser = true;
        }
        $this->slideInUser = $slideInUser;
    }
}
