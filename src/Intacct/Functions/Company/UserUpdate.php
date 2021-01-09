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
 * Update an existing user record
 */
class UserUpdate extends AbstractUser
{

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

        $xml->startElement('update');
        $xml->startElement('USERINFO');

        if (!$this->getUserId()) {
            throw new InvalidArgumentException('User ID is required for update');
        }
        $xml->writeElement('LOGINID', $this->getUserId(), true);

        $xml->writeElement('USERTYPE', $this->getUserType());
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
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
