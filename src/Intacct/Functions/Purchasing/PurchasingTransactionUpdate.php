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

namespace Intacct\Functions\Purchasing;

use Intacct\Xml\XMLWriter;

/**
 * Update as existing purchasing transaction record
 */
class PurchasingTransactionUpdate extends AbstractPurchasingTransaction
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

        $xml->startElement('update_potransaction');
        if ($this->getExternalId()) {
            $xml->writeAttribute('key', $this->getExternalId());
            $xml->writeAttribute('externalkey', 'true'); //TODO fix writeAttribute to accept bool
        } else {
            $xml->writeAttribute('key', $this->getDocumentNumber());
        }

        if ( $this->getTransactionDate() ) {
            $xml->startElement('datecreated');
            $xml->writeDateSplitElements($this->getTransactionDate(), true);
            $xml->endElement(); //datecreated
        }

        if ( $this->getGlPostingDate() ) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('referenceno', $this->getReferenceNumber());
        $xml->writeElement('vendordocno', $this->getVendorDocNumber());
        $xml->writeElement('termname', $this->getPaymentTerm());

        if ( $this->getDueDate() ) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->getDueDate(), true);
            $xml->endElement(); //datedue
        }

        $xml->writeElement('message', $this->getMessage());
        $xml->writeElement('shippingmethod', $this->getShippingMethod());

        if ( $this->getReturnToContactName() ) {
            $xml->startElement('returnto');
            $xml->writeElement('contactname', $this->getReturnToContactName(), true);
            $xml->endElement(); //returnto

        }

        if ( $this->getPayToContactName() ) {
            $xml->startElement('payto');
            $xml->writeElement('contactname', $this->getPayToContactName(), true);
            $xml->endElement(); //payto

        }

        $xml->writeElement('supdocid', $this->getAttachmentsId());
        $xml->writeElement('externalid', $this->getExternalId());

        $xml->writeElement('basecurr', $this->getBaseCurrency());
        $xml->writeElement('currency', $this->getTransactionCurrency());

        if ( $this->getExchangeRateDate() ) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->getExchangeRateDate(), true);
            $xml->endElement();
        }

        if ( $this->getExchangeRateType() ) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType());
        } elseif ( $this->getExchangeRateValue() ) {
            $xml->writeElement('exchrate', $this->getExchangeRateValue());
        } elseif ( $this->getBaseCurrency() || $this->getTransactionCurrency() ) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType(), true);
        }

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('state', $this->getState());

        if (count($this->getLines()) > 0) {
            $xml->startElement('updatepotransitems');
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
            $xml->endElement(); //updatepotransitems
        }

        if (count($this->getSubtotals()) > 0) {
            $xml->startElement('updatesubtotals');
            foreach ($this->getSubtotals() as $subtotal) {
                $subtotal->writeXml($xml);
            }
            $xml->endElement(); //subtotals
        }

        $xml->endElement(); //update_potransaction

        $xml->endElement(); //function
    }
}