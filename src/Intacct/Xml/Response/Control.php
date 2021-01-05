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

namespace Intacct\Xml\Response;

use Intacct\Exception\IntacctException;

class Control
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
    private $senderId;

    /**
     * @return string
     */
    public function getSenderId(): string
    {
        return $this->senderId;
    }

    /**
     * @param string $senderId
     */
    private function setSenderId(string $senderId)
    {
        $this->senderId = $senderId;
    }

    /** @var string */
    private $controlId;

    /**
     * @return string
     */
    public function getControlId(): string
    {
        return $this->controlId;
    }

    /**
     * @param string $controlId
     */
    private function setControlId(string $controlId)
    {
        $this->controlId = $controlId;
    }

    /** @var string */
    private $uniqueId;

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     */
    private function setUniqueId(string $uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }

    /** @var string */
    private $dtdVersion;

    /**
     * @return string
     */
    public function getDtdVersion(): string
    {
        return $this->dtdVersion;
    }

    /**
     * @param string $dtdVersion
     */
    private function setDtdVersion(string $dtdVersion)
    {
        $this->dtdVersion = $dtdVersion;
    }

    /**
     * Control constructor.
     *
     * @param \SimpleXMLElement $control
     */
    public function __construct(\SimpleXMLElement $control)
    {
        if (!isset($control->status)) {
            throw new IntacctException('Control block is missing status element');
        }

        $this->setStatus(strval($control->status));
        $this->setSenderId(strval($control->senderid));
        $this->setControlId(strval($control->controlid));
        $this->setUniqueId(strval($control->uniqueid));
        $this->setDtdVersion(strval($control->dtdversion));
    }
}
