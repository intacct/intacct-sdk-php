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

use Intacct\Exception;
use SimpleXMLIterator;

class Control
{

    /** @var string */
    private $status;

    /** @var string */
    private $senderId;

    /** @var string */
    private $controlId;

    /** @var string */
    private $uniqueId;

    /** @var string */
    private $dtdVersion;

    /**
     * Initializes the class
     *
     * @param SimpleXMLIterator $control
     * @throws Exception
     */
    public function __construct(SimpleXMLIterator $control)
    {
        if (!isset($control->status)) {
            throw new Exception('Control block is missing status element');
        }
        if (!isset($control->senderid)) {
            throw new Exception('Control block is missing senderid element');
        }
        if (!isset($control->controlid)) {
            throw new Exception('Control block is missing controlid element');
        }
        if (!isset($control->uniqueid)) {
            throw new Exception('Control block is missing uniqueid element');
        }
        if (!isset($control->dtdversion)) {
            throw new Exception('Control block is missing dtdversion element');
        }

        $this->status = strval($control->status);
        $this->senderId = strval($control->senderid);
        $this->controlId = strval($control->controlid);
        $this->uniqueId = strval($control->uniqueid);
        $this->dtdVersion = strval($control->dtdversion);
    }

    /**
     * Get control status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get sender ID
     *
     * @return string
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Get control ID
     *
     * @return string
     */
    public function getControlId()
    {
        return $this->controlId;
    }

    /**
     * Get unique ID
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * Get DTD version
     *
     * @return string
     */
    public function getDtdVersion()
    {
        return $this->dtdVersion;
    }
}
