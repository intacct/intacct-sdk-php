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

namespace Intacct\Functions\AccountsReceivable\PaymentServices;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Update an existing customer charge card record
 */
class CustomerChargeCardUpdate extends AbstractCustomerChargeCard
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

        $xml->startElement('update_customerchargecard');

        if (!$this->getRecordNo()) {
            throw new InvalidArgumentException('Record No is required for update');
        }
        $xml->writeAttribute('recordno', $this->getRecordNo(), true);

        $xml->writeElement('exp_month', $this->getExpirationMonth());
        $xml->writeElement('exp_year', $this->getExpirationYear());
        $xml->writeElement('description', $this->getDescription());

        if ($this->isActive() === true) {
            $xml->writeElement('status', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('status', 'inactive');
        }

        if (
            $this->getAddressLine1()
            || $this->getAddressLine2()
            || $this->getCity()
            || $this->getStateProvince()
            || $this->getZipPostalCode()
            || $this->getCountry()
        ) {
            $xml->startElement('mailaddress');
            $xml->writeElement('address1', $this->getAddressLine1());
            $xml->writeElement('address2', $this->getAddressLine2());
            $xml->writeElement('city', $this->getCity());
            $xml->writeElement('state', $this->getStateProvince());
            $xml->writeElement('zip', $this->getZipPostalCode());
            $xml->writeElement('country', $this->getCountry());
            $xml->endElement(); //mailaddress
        }

        $xml->writeElement('defaultcard', $this->isDefaultCard());
        $xml->writeElement('usebilltoaddr', $this->isBillToContactAddressUsedForVerification());

        $xml->endElement(); //update_customerchargecard

        $xml->endElement(); //function
    }
}
