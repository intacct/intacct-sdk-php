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

namespace Intacct\Functions\SubsidiaryLedger;

use Intacct\Fields\Date;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractArTransaction extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $customerId;

    /** @var Date */
    protected $transactionDate;

    /** @var Date */
    protected $glPostingDate;

    /** @var string */
    protected $action;

    /** @var string|int */
    protected $batchKey;

    /** @var string */
    protected $invoiceNumber;

    /** @var string */
    protected $description;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $baseCurrency;

    /** @var string */
    protected $transactionCurrency;

    /** @var Date */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var bool */
    protected $doNotPostToGL;

    /** @var Date */
    protected $dueDate;

    /** @var string */
    protected $paymentTerm;

    /** @var string */
    protected $referenceNumber;

    /** @var bool */
    protected $onHold;

    /** @var string */
    protected $billToContactName;

    /** @var string */
    protected $shipToContactName;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $adjustmentNumber;

    /** @var array */
    protected $entries;

    /**
     * @param XMLWriter $xml
     */
    protected function writeXmlMultiCurrencySection(XMLWriter &$xml)
    {
        $xml->writeElement('basecurr', $this->baseCurrency);
        $xml->writeElement('currency', $this->transactionCurrency);

        if ($this->exchangeRateDate) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->exchangeRateDate, true);
            $xml->endElement();
        }

        if ($this->exchangeRateType) {
            $xml->writeElement('exchratetype', $this->exchangeRateType);
        } elseif ($this->exchangeRateValue) {
            $xml->writeElement('exchrate', $this->exchangeRateValue);
        } elseif ($this->baseCurrency || $this->transactionCurrency) {
            $xml->writeElement('exchratetype', $this->exchangeRateType, true);
        }
    }

}