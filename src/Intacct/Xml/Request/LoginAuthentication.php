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

use Intacct\Xml\XMLWriter;

class LoginAuthentication implements AuthenticationInterface
{

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
    public function setUserId(string $userId)
    {
        if (!$userId) {
            throw new \InvalidArgumentException(
                'User ID is required and cannot be blank'
            );
        }
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
    public function setCompanyId(string $companyId)
    {
        if (!$companyId) {
            throw new \InvalidArgumentException(
                'Company ID is required and cannot be blank'
            );
        }
        $this->companyId = $companyId;
    }

    /** @var string|null */
    private $entityId;

    /**
     * @return string|null
     */
    public function getEntityId() //: string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId(string $entityId)
    {
        $this->entityId = $entityId;
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
                'User Password is required and cannot be blank'
            );
        }
        $this->password = $password;
    }

    /**
     * LoginAuthentication constructor.
     *
     * @param string $userId
     * @param string $companyId
     * @param string $password
     * @param string|null $entityId
     */
    public function __construct(string $userId, string $companyId, string $password, string $entityId = null)
    {
        $this->setUserId($userId);
        $this->setCompanyId($companyId);
        $this->setPassword($password);
        if ($entityId !== null) {
            $this->setEntityId($entityId);
        }
    }

    /**
     * Write the operation block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('authentication');
        $xml->startElement('login');
        $xml->writeElement('userid', $this->getUserId(), true);
        $xml->writeElement('companyid', $this->getCompanyId(), true);
        $xml->writeElement('password', $this->getPassword(), true);
        if ($this->getEntityId() !== null) {
            $xml->writeElement('locationid', $this->getEntityId());
        }
        $xml->endElement(); //login
        $xml->endElement(); //authentication
    }
}
