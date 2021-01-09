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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new accounts payable payment request record
 */
class ApPaymentCreate extends AbstractFunction
{
    /** @var ApPaymentInfo */
    private $_apPaymentInfo;

    public function __construct(ApPaymentInfo $apPaymentInfo, string $controlId)
    {
        parent::__construct($controlId);
        $this->_apPaymentInfo = $apPaymentInfo;
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

        $xml->startElement('create');
        $xml->startElement('APPYMT');

        $xml->writeElement('PAYMENTMETHOD', $this->_apPaymentInfo->paymentMethod, true);
        $xml->writeElement('FINANCIALENTITY', $this->_apPaymentInfo->financialEntityId, true);
        $xml->writeElement('VENDORID', $this->_apPaymentInfo->vendorId, true);

        if (isset($this->_apPaymentInfo->mergeOption)) {
            $xml->writeElement('PAYMENTREQUESTMETHOD', $this->_apPaymentInfo->mergeOption, true);
        }

        if (isset($this->_apPaymentInfo->groupPayments)) {
            $xml->writeElement('GROUPPAYMENTS', $this->_apPaymentInfo->groupPayments);
        }

        if (isset($this->_apPaymentInfo->exchangeRateDate)) {
            $xml->writeElementDate('EXCH_RATE_DATE', $this->_apPaymentInfo->exchangeRateDate, XMLWriter::IA_DATE_FORMAT);
        }

        if (isset($this->_apPaymentInfo->exchangeRateType)) {
            $xml->writeElement('EXCH_RATE_TYPE_ID', $this->_apPaymentInfo->exchangeRateType);
        }

        if (isset($this->_apPaymentInfo->documentNo)) {
            $xml->writeElement('DOCNUMBER', $this->_apPaymentInfo->documentNo);
        }

        if (isset($this->_apPaymentInfo->memo)) {
            $xml->writeElement('DESCRIPTION', $this->_apPaymentInfo->memo);
        }

        if (isset($this->_apPaymentInfo->notificationContactName)) {
            $xml->writeElement('PAYMENTCONTACT', $this->_apPaymentInfo->notificationContactName);
        }

        if (isset($this->_apPaymentInfo->paymentDate)) {
            $xml->writeElementDate('PAYMENTDATE', $this->_apPaymentInfo->paymentDate, XMLWriter::IA_DATE_FORMAT, true);
        }

        if (isset($this->_apPaymentInfo->transactionCurrency)) {
            $xml->writeElement('CURRENCY', $this->_apPaymentInfo->transactionCurrency);
        }

        if (isset($this->_apPaymentInfo->baseCurrency)) {
            $xml->writeElement('BASECURR', $this->_apPaymentInfo->baseCurrency);
        }

        if (isset($this->_apPaymentInfo->transactionAmountPaid)) {
            $xml->writeElement('AMOUNTTOPAY', $this->_apPaymentInfo->transactionAmountPaid);
        }

        if (isset($this->_apPaymentInfo->action)) {
            $xml->writeElement('ACTION', $this->_apPaymentInfo->action);
        }

        if (isset($this->_apPaymentInfo->apPaymentDetails) && count($this->_apPaymentInfo->apPaymentDetails) > 0) {
            $xml->startElement('APPYMTDETAILS');
            foreach ($this->_apPaymentInfo->apPaymentDetails as $line) {
                $line->writeXml($xml);
            }

            $xml->endElement(); // APPYMTDETAILS
        }

        $xml->endElement(); // APPYMT
        $xml->endElement(); // create

        $xml->endElement(); // function
    }
}
