<?php

/**
 * Copyright 2017 Intacct Corporation.
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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Void an existing AP payment request record
 */
class ApPaymentRequestVoid extends AbstractApPaymentRequest
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

        $xml->startElement('void_appaymentrequest');

        if (!$this->getRecordNo()) {
            throw new InvalidArgumentException('Record No is required for void');
        }
        $xml->startElement('appaymentkeys');

        $xml->writeElement('appaymentkey', $this->getRecordNo(), true);

        $xml->endElement(); //appaymentkeys

        $xml->endElement(); //void_appaymentrequest

        $xml->endElement(); //function
    }
}
