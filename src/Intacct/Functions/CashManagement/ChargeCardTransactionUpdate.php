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
 * Update an existing cash management charge card transaction record
 */
class ChargeCardTransactionUpdate extends AbstractChargeCardTransaction
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

        $xml->startElement('update_cctransaction');

        if (!$this->getRecordNo()) {
            throw new InvalidArgumentException('Record No is required for update');
        }
        $xml->writeAttribute('key', $this->getRecordNo());

        if ($this->getTransactionDate()) {
            $xml->startElement('paymentdate');
            $xml->writeDateSplitElements($this->getTransactionDate());
            $xml->endElement(); //paymentdate
        }

        $xml->writeElement('referenceno', $this->getReferenceNumber());
        $xml->writeElement('payee', $this->getPayee());
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

        if (count($this->getLines()) > 0) {
            $xml->startElement('updateccpayitems');
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
            $xml->endElement(); //updateccpayitems
        }

        $xml->endElement(); //update_cctransaction

        $xml->endElement(); //function
    }
}
