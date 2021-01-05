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

namespace Intacct\Functions\InventoryControl;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new inventory control transaction record
 */
class InventoryTransactionCreate extends AbstractInventoryTransaction
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_ictransaction');

        $xml->writeElement('transactiontype', $this->getTransactionDefinition(), true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate(), true);
        $xml->endElement(); //datecreated

        $xml->writeElement('createdfrom', $this->getCreatedFrom());
        $xml->writeElement('documentno', $this->getDocumentNumber());
        $xml->writeElement('referenceno', $this->getReferenceNumber());
        $xml->writeElement('message', $this->getMessage());
        $xml->writeElement('externalid', $this->getExternalId());
        $xml->writeElement('basecurr', $this->getBaseCurrency());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('state', $this->getState());

        $xml->startElement('ictransitems');
        if (count($this->getLines()) > 0) {
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
        } else {
            throw new InvalidArgumentException('IC Transaction must have at least 1 line');
        }
        $xml->endElement(); //ictransitems

        if (count($this->getSubtotals()) > 0) {
            $xml->startElement('subtotals');
            foreach ($this->getSubtotals() as $subtotal) {
                $subtotal->writeXml($xml);
            }
            $xml->endElement(); //subtotals
        }

        $xml->endElement(); //create_ictransaction

        $xml->endElement(); //function
    }
}
