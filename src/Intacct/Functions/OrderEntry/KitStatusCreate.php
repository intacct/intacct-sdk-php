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

namespace Intacct\Functions\OrderEntry;

use Intacct\Xml\XMLWriter;

class KitStatusCreate extends AbstractKitStatus
{
    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('fulfillmentstatus');
        $xml->startElement('kitstatus');

        if (isset($this->lineNo)) {
            $xml->writeElement('line_num', $this->lineNo);
        }

        if (isset($this->invoicePrice)) {
            $xml->writeElement('invoiceprice', $this->invoicePrice);
        }

        $this->writeXmlDetails($xml);

        $xml->endElement(); // kitstatus
        $xml->endElement(); // fulfillmentstatus
    }
}