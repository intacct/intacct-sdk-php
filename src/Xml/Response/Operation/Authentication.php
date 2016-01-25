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

namespace Intacct\Xml\Response\Operation;

use SimpleXMLIterator;
use Exception;

class Authentication
{

    /**
     *
     * @var string
     */
    private $status;

    /**
     *
     * @var string
     */
    private $userId;

    /**
     *
     * @var string
     */
    private $companyId;

    /**
     *
     * @var boolean
     */
    private $slideInUser;

    /**
     * 
     * @param SimpleXMLIterator $authentication
     * @throws Exception
     */
    public function __construct(SimpleXMLIterator $authentication)
    {
        if (!isset($authentication->status)) {
            throw new Exception('Authentication block is missing status element');
        }
        if (!isset($authentication->userid)) {
            throw new Exception('Authentication block is missing userid element');
        }
        if (!isset($authentication->companyid)) {
            throw new Exception('Authentication block is missing companyid element');
        }

        $this->status = strval($authentication->status);
        $this->userId = strval($authentication->userid);
        $this->companyId = strval($authentication->companyid);
        $this->setSlideInUser($this->userId);
        
        //TODO add getter/setter for elements: clientstatus, clientid, locationid, sessiontimestamp
    }

    /**
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * 
     * @return boolean
     */
    public function getSlideInUser()
    {
        return $this->slideInUser;
    }

    /**
     * 
     * @param string $userId
     */
    private function setSlideInUser($userId)
    {
        $slideInUser = false;
        if (strpos($userId, 'CPAUser') !== false) {
            $slideInUser = true;
        } else if (strpos($userId, 'ExtUser|') !== false) {
            $slideInUser = true;
        }
        $this->slideInUser = $slideInUser;
    }

}
