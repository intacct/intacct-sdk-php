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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Update an existing accounts receivable account label record
 */
class ArAccountLabelUpdate extends AbstractArAccountLabel
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
        $xml->startElement('ARACCOUNTLABEL');

        if (!$this->getAccountLabel()) {
            throw new InvalidArgumentException('Account Label is required for update');
        }
        $xml->writeElement('ACCOUNTLABEL', $this->getAccountLabel(), true);

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('GLACCOUNTNO', $this->getGlAccountNo());
        $xml->writeElement('OFFSETGLACCOUNTNO', $this->getOffsetGlAccountNo());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $xml->endElement(); //ARACCOUNTLABEL
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
