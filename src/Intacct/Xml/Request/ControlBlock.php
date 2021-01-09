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

namespace Intacct\Xml\Request;

use Intacct\ClientConfig;
use Intacct\RequestConfig;
use Intacct\Xml\XMLWriter;

class ControlBlock
{

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
    public function setSenderId(string $senderId)
    {
        if (!$senderId) {
            throw new \InvalidArgumentException(
                'Sender ID is required and cannot be blank'
            );
        }
        $this->senderId = $senderId;
    }
    
    /** @var string */
    private $password;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        if (!$password) {
            throw new \InvalidArgumentException(
                'Sender Password is required and cannot be blank'
            );
        }
        $this->password = $password;
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
    public function setControlId(string $controlId)
    {
        $length = strlen($controlId);
        if ($length < 1 || $length > 256) {
            throw new \InvalidArgumentException(
                'Request Control ID must be between 1 and 256 characters in length'
            );
        }
        $this->controlId = $controlId;
    }
    
    /** @var bool */
    private $uniqueId;

    /**
     * @return bool
     */
    public function isUniqueId(): bool
    {
        return $this->uniqueId;
    }

    /**
     * @param bool $uniqueId
     */
    public function setUniqueId(bool $uniqueId)
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
    
    /** @var string */
    private $policyId;

    /**
     * @return string
     */
    public function getPolicyId(): string
    {
        return $this->policyId;
    }

    /**
     * @param string $policyId
     */
    public function setPolicyId(string $policyId)
    {
        $this->policyId = $policyId;
    }
    
    /** @var bool */
    private $includeWhitespace;

    /**
     * @return bool
     */
    public function isIncludeWhitespace(): bool
    {
        return $this->includeWhitespace;
    }

    /**
     * @param bool $includeWhitespace
     */
    public function setIncludeWhitespace(bool $includeWhitespace)
    {
        $this->includeWhitespace = $includeWhitespace;
    }

    /**
     * ControlBlock constructor.
     *
     * @param ClientConfig $clientConfig
     * @param RequestConfig $requestConfig
     */
    public function __construct(ClientConfig $clientConfig, RequestConfig $requestConfig)
    {
        $this->setSenderId($clientConfig->getSenderId());
        $this->setPassword($clientConfig->getSenderPassword());
        $this->setControlId($requestConfig->getControlId());
        $this->setUniqueId($requestConfig->isUniqueId());
        $this->setPolicyId($requestConfig->getPolicyId());
        $this->setIncludeWhitespace(false);
        $this->setDtdVersion('3.0');
    }

    /**
     * Write the control block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('control');
        $xml->writeElement('senderid', $this->getSenderId(), true);
        $xml->writeElement('password', $this->getPassword(), true);
        $xml->writeElement('controlid', $this->getControlId(), true);
        if ($this->isUniqueId() === true) {
            $xml->writeElement('uniqueid', 'true');
        } else {
            $xml->writeElement('uniqueid', 'false');
        }
        $xml->writeElement('dtdversion', $this->getDtdVersion(), true);
        if ($this->getPolicyId()) {
            $xml->writeElement('policyid', $this->getPolicyId());
        }
        $xml->writeElement('includewhitespace', $this->isIncludeWhitespace());
        $xml->endElement(); //control
    }
}
