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

namespace Intacct\Functions\CashManagement;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new cash management other receipt record
 */
class OtherReceiptCreate extends AbstractOtherReceipt
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

        $xml->startElement('record_otherreceipt');

        $xml->startElement('paymentdate');
        $xml->writeDateSplitElements($this->getTransactionDate());
        $xml->endElement(); //paymentdate

        $xml->writeElement('payee', $this->getPayer(), true);

        $xml->startElement('receiveddate');
        $xml->writeDateSplitElements($this->getReceiptDate());
        $xml->endElement(); //receiveddate

        $xml->writeElement('paymentmethod', $this->getPaymentMethod(), true);

        if ($this->getBankAccountId() || $this->getDepositDate()) {
            $xml->writeElement('bankaccountid', $this->getBankAccountId(), true);
            if ($this->getDepositDate()) {
                $xml->startElement('depositdate');
                $xml->writeDateSplitElements($this->getDepositDate(), true);
                $xml->endElement(); //depositdate
            }
        } else {
            $xml->writeElement('undepglaccountno', $this->getUndepositedFundsGlAccountNo(), true);
        }

        $xml->writeElement('refid', $this->getTransactionNo());
        $xml->writeElement('description', $this->getDescription());
        $xml->writeElement('supdocid', $this->getAttachmentsId());

        $xml->writeElement('currency', $this->getTransactionCurrency());

        if ($this->getExchangeRateValue()) {
            $xml->writeElement('exchrate', $this->getExchangeRateValue());
        } elseif ($this->getExchangeRateDate() || $this->getExchangeRateType()) {
            if ($this->getExchangeRateDate()) {
                $xml->startElement('exchratedate');
                $xml->writeDateSplitElements($this->getExchangeRateDate(), true);
                $xml->endElement();
            }
            $xml->writeElement('exchratetype', $this->getExchangeRateType(), true);
        }

        $this->writeXmlExplicitCustomFields($xml);

        $xml->startElement('receiptitems');
        if (count($this->getLines()) > 0) {
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
        } else {
            throw new InvalidArgumentException('CM Other Receipt must have at least 1 line');
        }
        $xml->endElement(); //receiptitems

        $xml->endElement(); //record_otherreceipt

        $xml->endElement(); //function
    }
}
