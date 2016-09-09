<?php

/**
 * Copyright 2016 Intacct Corporation.
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
 * Send an existing AP payment request record
 */
class ApPaymentRequestSend extends AbstractApPaymentRequest
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

        $xml->startElement('send_appaymentrequest');

        if (!$this->getRecordNo()) {
            throw new InvalidArgumentException('Record No is required for send');
        }
        $xml->startElement('appaymentkeys');

        $xml->writeElement('appaymentkey', $this->getRecordNo(), true);
        
        $xml->endElement(); //appaymentkeys

        $xml->endElement(); //send_appaymentrequest

        $xml->endElement(); //function
    }
}
