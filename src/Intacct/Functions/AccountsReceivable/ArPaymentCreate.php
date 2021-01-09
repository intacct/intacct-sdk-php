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
 * Create a new accounts receivable payment record
 */
class ArPaymentCreate extends AbstractArPayment
{

    /**
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_arpayment');

        if (!$this->getCustomerId()) {
            throw new InvalidArgumentException('Customer ID is required for create');
        }
        $xml->writeElement('customerid', $this->getCustomerId(), true);
        $xml->writeElement('paymentamount', $this->getTransactionPaymentAmount(), true);
        $xml->writeElement('batchkey', $this->getSummaryRecordNo());
        $xml->writeElement('translatedamount', $this->getBasePaymentAmount());

        if ($this->getUndepositedFundsGlAccountNo()) {
            $xml->writeElement('undepfundsacct', $this->getUndepositedFundsGlAccountNo());
        } elseif ($this->getBankAccountId()) {
            $xml->writeElement('bankaccountid', $this->getBankAccountId());
        }

        $xml->writeElement('refid', $this->getReferenceNumber());
        $xml->writeElement('overpaylocid', $this->getOverpaymentLocationId());
        $xml->writeElement('overpaydeptid', $this->getOverpaymentDepartmentId());

        if (!$this->getReceivedDate()) {
            throw new InvalidArgumentException('Received Date is required for create');
        }
        $xml->startElement('datereceived');
        $xml->writeDateSplitElements($this->getReceivedDate(), true);
        $xml->endElement(); //datereceived

        if (!$this->getPaymentMethod()) {
            throw new InvalidArgumentException('Payment Method is required for create');
        }
        $xml->writeElement('paymentmethod', $this->getPaymentMethod(), true);

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

        $xml->writeElement('cctype', $this->getCreditCardType());
        $xml->writeElement('authcode', $this->getAuthorizationCode());

        if (count($this->getApplyToTransactions()) > 0) {
            foreach ($this->getApplyToTransactions() as $applyToTransaction) {
                $applyToTransaction->writeXml($xml);
            }
        }

        //TODO online payment methods

        $xml->endElement(); //create_arpayment

        $xml->endElement(); //function
    }
}
