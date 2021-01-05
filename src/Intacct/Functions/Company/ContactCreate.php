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
 * Create a new contact record
 */
class ContactCreate extends AbstractContact
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
        $xml->startElement('CONTACT');

        if (!$this->getContactName()) {
            throw new InvalidArgumentException('Contact Name is required for create');
        }
        $xml->writeElement('CONTACTNAME', $this->getContactName(), true);
        if (!$this->getPrintAs()) {
            throw new InvalidArgumentException('Print As is required for create');
        }
        $xml->writeElement('PRINTAS', $this->getPrintAs(), true);

        $xml->writeElement('COMPANYNAME', $this->getCompanyName());
        $xml->writeElement('TAXABLE', $this->isTaxable());
        $xml->writeElement('TAXID', $this->getTaxId());
        $xml->writeElement('TAXGROUP', $this->getContactTaxGroupName());
        $xml->writeElement('PREFIX', $this->getPrefix());
        $xml->writeElement('FIRSTNAME', $this->getFirstName());
        $xml->writeElement('LASTNAME', $this->getLastName());
        $xml->writeElement('INITIAL', $this->getMiddleName());
        $xml->writeElement('PHONE1', $this->getPrimaryPhoneNo());
        $xml->writeElement('PHONE2', $this->getSecondaryPhoneNo());
        $xml->writeElement('CELLPHONE', $this->getCellularPhoneNo());
        $xml->writeElement('PAGER', $this->getPagerNo());
        $xml->writeElement('FAX', $this->getFaxNo());
        $xml->writeElement('EMAIL1', $this->getPrimaryEmailAddress());
        $xml->writeElement('EMAIL2', $this->getSecondaryEmailAddress());
        $xml->writeElement('URL1', $this->getPrimaryUrl());
        $xml->writeElement('URL2', $this->getSecondaryUrl());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlMailAddress($xml);

        $xml->endElement(); //CONTACT
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
