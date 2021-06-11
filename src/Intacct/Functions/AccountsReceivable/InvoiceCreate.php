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
 * Create a new accounts receivable invoice record
 */
class InvoiceCreate extends AbstractInvoice
{

    /**
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_invoice');

        $xml->writeElement('customerid', $this->getCustomerId(), true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate(), true);
        $xml->endElement(); //datecreated

        if ($this->getGlPostingDate()) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        if ($this->getDueDate()) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->getDueDate(), true);
            $xml->endElement(); // datedue

            $xml->writeElement('termname', $this->getPaymentTerm());
        } else {
            $xml->writeElement('termname', $this->getPaymentTerm(), true);
        }

        $xml->writeElement('action', $this->getAction());
        $xml->writeElement('batchkey', $this->getSummaryRecordNo());
        $xml->writeElement('invoiceno', $this->getInvoiceNumber());
        $xml->writeElement('ponumber', $this->getReferenceNumber());
        $xml->writeElement('onhold', $this->isOnHold());
        $xml->writeElement('description', $this->getDescription());
        $xml->writeElement('externalid', $this->getExternalId());

        if ($this->getBillToContactName()) {
            $xml->startElement('billto');
            $xml->writeElement('contactname', $this->getBillToContactName(), true);
            $xml->endElement(); //billto
        }

        if ($this->getShipToContactName()) {
            $xml->startElement('shipto');
            $xml->writeElement('contactname', $this->getShipToContactName(), true);
            $xml->endElement(); //shipto
        }

        $this->writeXmlMultiCurrencySection($xml);

        $xml->writeElement('nogl', $this->isDoNotPostToGL());
        $xml->writeElement('supdocid', $this->getAttachmentsId());
        $xml->writeElement('taxsolutionid', $this->getTaxSolutionId());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->startElement('invoiceitems');
        if (count($this->getLines()) > 0) {
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
        } else {
            throw new InvalidArgumentException('AR Invoice must have at least 1 line');
        }
        $xml->endElement(); //invoiceitems

        $xml->endElement(); //create_invoice

        $xml->endElement(); //function
    }
}
