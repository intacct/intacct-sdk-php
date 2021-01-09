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

namespace Intacct\Functions\Company;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new user record
 */
class UserCreate extends AbstractUser
{

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $primaryEmailAddress;

    /** @var string */
    protected $contactName;

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getPrimaryEmailAddress()
    {
        return $this->primaryEmailAddress;
    }

    /**
     * @param string $primaryEmailAddress
     */
    public function setPrimaryEmailAddress($primaryEmailAddress)
    {
        if (filter_var($primaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Primary Email Address is not a valid email');
        }
        $this->primaryEmailAddress = $primaryEmailAddress;
    }

    /**
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param string $contactName
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create');
        $xml->startElement('USERINFO');

        if (!$this->getUserId()) {
            throw new InvalidArgumentException('User ID is required for create');
        }
        $xml->writeElement('LOGINID', $this->getUserId(), true);
        if (!$this->getUserType()) {
            throw new InvalidArgumentException('User Type is required for create');
        }
        $xml->writeElement('USERTYPE', $this->getUserType(), true);

        if (
            !($this->getLastName() && $this->getFirstName() && $this->getPrimaryEmailAddress())
            && !$this->getContactName()
        ) {
            throw new InvalidArgumentException(
                'Last Name, First Name, and Primary Email, or an existing Contact Name, are required for create'
            );
        }
        $xml->startElement('CONTACTINFO');
        $xml->writeElement('LASTNAME', $this->getLastName());
        $xml->writeElement('FIRSTNAME', $this->getFirstName());
        $xml->writeElement('EMAIL1', $this->getPrimaryEmailAddress());
        $xml->writeElement('CONTACTNAME', $this->getContactName());
        $xml->endElement(); //CONTACTINFO

        $xml->writeElement('DESCRIPTION', $this->getUserName());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $xml->writeElement('LOGINDISABLED', $this->isWebServicesOnly());
        $xml->writeElement('SSO_ENABLED', $this->isSsoEnabled());
        $xml->writeElement('SSO_FEDERATED_ID', $this->getSsoFederatedUserId());

        if (count($this->getRestrictedEntities()) > 0) {
            foreach ($this->getRestrictedEntities() as $restrictedEntity) {
                $xml->startElement('USERLOCATIONS');
                $xml->writeElement('LOCATIONID', $restrictedEntity, true);
                $xml->endElement(); //USERLOCATIONS
            }
        }

        if (count($this->getRestrictedDepartments()) > 0) {
            foreach ($this->getRestrictedDepartments() as $restrictedDepartment) {
                $xml->startElement('USERDEPARTMENTS');
                $xml->writeElement('DEPARTMENTID', $restrictedDepartment, true);
                $xml->endElement(); //USERDEPARTMENTS
            }
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //USERINFO
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
