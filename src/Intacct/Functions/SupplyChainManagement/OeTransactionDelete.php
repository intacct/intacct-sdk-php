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

namespace Intacct\Functions\SupplyChainManagement;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Delete an existing OE transaction record
 */
class OeTransactionDelete extends AbstractOeTransaction
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

        $xml->startElement('delete_sotransaction');

        if (!$this->getDocumentId()) {
            throw new InvalidArgumentException('Document ID is required for delete');
        }
        $xml->writeAttribute('key', $this->getDocumentId());

        $xml->endElement(); //delete_sotransaction

        $xml->endElement(); //function
    }
}