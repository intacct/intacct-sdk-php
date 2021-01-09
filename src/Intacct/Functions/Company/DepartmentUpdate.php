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
 * Update an existing department record
 */
class DepartmentUpdate extends AbstractDepartment
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
        $xml->startElement('DEPARTMENT');

        if (!$this->getDepartmentId()) {
            throw new InvalidArgumentException('Department ID is required for update');
        }
        $xml->writeElement('DEPARTMENTID', $this->getDepartmentId(), true);

        $xml->writeElement('TITLE', $this->getDepartmentName());
        $xml->writeElement('PARENTID', $this->getParentDepartmentId());
        $xml->writeElement('SUPERVISORID', $this->getManagerEmployeeId());
        $xml->writeElement('CUSTTITLE', $this->getDepartmentTitle());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //DEPARTMENT
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
