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

/**
 * Update an existing order entry transaction record
 */
class OrderEntryTransactionUpdate extends AbstractOrderEntryTransaction
{

    /** @var string */
    private $transactionId;

    /** @var bool */
    private $disableValidation;

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return bool
     */
    public function isDisableValidation()
    {
        return $this->disableValidation;
    }

    /**
     * @param bool $disableValidation
     */
    public function setDisableValidation($disableValidation)
    {
        $this->disableValidation = $disableValidation;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('update_sotransaction');
        if ($this->getExternalId()) {
            $xml->writeAttribute('key', $this->getExternalId());
            $xml->writeAttribute('externalkey', 'true'); //TODO fix writeAttribute to accept bool
        } else {
            $xml->writeAttribute('key', $this->getTransactionId());
        }
        if ($this->isDisableValidation()) {
            $xml->writeAttribute('disablevalidation', $this->isDisableValidation());
        }

        if ($this->getTransactionDate()) {
            $xml->startElement('datecreated');
            $xml->writeDateSplitElements($this->getTransactionDate(), true);
            $xml->endElement(); //datecreated
        }

        if ($this->getGlPostingDate()) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('referenceno', $this->getReferenceNumber());
        $xml->writeElement('termname', $this->getPaymentTerm());

        if ($this->getDueDate()) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->getDueDate(), true);
            $xml->endElement(); //datedue
        }

        if ($this->getOriginalDocumentDate()) {
            $xml->startElement('origdocdate');
            $xml->writeDateSplitElements($this->getOriginalDocumentDate(), true);
            $xml->endElement(); //origdocdate
        }

        $xml->writeElement('message', $this->getMessage());
        $xml->writeElement('shippingmethod', $this->getShippingMethod());
        if ($this->getShipToContactName()) {
            $xml->startElement('shipto');
            $xml->writeElement('contactname', $this->getShipToContactName(), true);
            $xml->endElement();
        }
        if ($this->getBillToContactName()) {
            $xml->startElement('billto');
            $xml->writeElement('contactname', $this->getBillToContactName(), true);
            $xml->endElement();
        }
        $xml->writeElement('supdocid', $this->getAttachmentsId());

        //does this let you actually update it? what if externalkey=true?
        //$xml->writeElement('externalid', $this->getExternalId());

        $xml->writeElement('basecurr', $this->getBaseCurrency());
        $xml->writeElement('currency', $this->getTransactionCurrency());

        if ($this->getExchangeRateDate()) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->getExchangeRateDate(), true);
            $xml->endElement();
        }

        if ($this->getExchangeRateType()) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType());
        } elseif ($this->getExchangeRateValue()) {
            $xml->writeElement('exchrate', $this->getExchangeRateValue());
        } elseif ($this->getBaseCurrency() || $this->getTransactionCurrency()) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType(), true);
        }

        $xml->writeElement('vsoepricelist', $this->getVsoePriceList());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('state', $this->getState());
        $xml->writeElement('projectid', $this->getProjectId());

        if (count($this->getLines()) > 0) {
            $xml->startElement('updatesotransitems');
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
            $xml->endElement(); //sotransitems
        }

        if (count($this->getSubtotals()) > 0) {
            $xml->startElement('updatesubtotals');
            foreach ($this->getSubtotals() as $subtotal) {
                $subtotal->writeXml($xml);
            }
            $xml->endElement(); //updatesubtotals
        }

        $xml->endElement(); //update_sotransaction

        $xml->endElement(); //function
    }
}
