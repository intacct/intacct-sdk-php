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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new employee record
 */
class EmployeeCreate extends AbstractEmployee
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

        $xml->startElement('create');
        $xml->startElement('EMPLOYEE');

        // Employee ID is not required if auto-numbering is configured in module
        $xml->writeElement('EMPLOYEEID', $this->getEmployeeId());

        if (!$this->getContactName()) {
            throw new InvalidArgumentException('Contact Name is required for create');
        }
        $xml->startElement('PERSONALINFO');
        $xml->writeElement('CONTACTNAME', $this->getContactName(), true);
        $xml->endElement(); //PERSONALINFO

        $xml->writeElementDate('STARTDATE', $this->getStartDate());
        $xml->writeElement('TITLE', $this->getTitle());
        $xml->writeElement('SSN', $this->getSsn());
        $xml->writeElement('EMPLOYEETYPE', $this->getEmployeeType());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $xml->writeElementDate('BIRTHDATE', $this->getBirthDate());
        $xml->writeElementDate('ENDDATE', $this->getEndDate());
        $xml->writeElement('TERMINATIONTYPE', $this->getTerminationType());
        $xml->writeElement('SUPERVISORID', $this->getManagerEmployeeId());
        $xml->writeElement('GENDER', $this->getGender());
        $xml->writeElement('DEPARTMENTID', $this->getDepartmentId());
        $xml->writeElement('LOCATIONID', $this->getLocationId());
        $xml->writeElement('CLASSID', $this->getClassId());
        $xml->writeElement('CURRENCY', $this->getDefaultCurrency());
        $xml->writeElement('EARNINGTYPENAME', $this->getEarningTypeName());
        $xml->writeElement('POSTACTUALCOST', $this->isPostActualCost());
        $xml->writeElement('NAME1099', $this->getForm1099Name());
        $xml->writeElement('FORM1099TYPE', $this->getForm1099Type());
        $xml->writeElement('FORM1099BOX', $this->getForm1099Box());
        $xml->writeElement('SUPDOCFOLDERNAME', $this->getAttachmentFolderName());
        $xml->writeElement('PAYMETHODKEY', $this->getPreferredPaymentMethod());
        $xml->writeElement('PAYMENTNOTIFY', $this->isSendAutomaticPaymentNotification());
        $xml->writeElement('MERGEPAYMENTREQ', $this->isMergePaymentRequests());
        $xml->writeElement('ACHENABLED', $this->isAchEnabled());
        $xml->writeElement('ACHBANKROUTINGNUMBER', $this->getAchBankRoutingNo());
        $xml->writeElement('ACHACCOUNTNUMBER', $this->getAchBankAccountNo());
        $xml->writeElement('ACHACCOUNTTYPE', $this->getAchBankAccountType());
        $xml->writeElement('ACHREMITTANCETYPE', $this->getAchBankAccountClass());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //EMPLOYEE
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
