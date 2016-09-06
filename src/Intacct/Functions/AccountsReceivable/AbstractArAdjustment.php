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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\FieldTypes\DateType;
use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

abstract class AbstractArAdjustment extends AbstractFunction
{

    //TODO: use CustomFieldsTrait;

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $customerId;

    /** @var DateType */
    protected $transactionDate;

    /** @var DateType */
    protected $glPostingDate;

    /** @var string */
    protected $action;

    /** @var string|int */
    protected $summaryRecordNo;

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

    /** @var DateType */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var bool */
    protected $doNotPostToGL;

    /** @var string */
    protected $adjustmentNumber;

    /** @var AbstractArAdjustmentLine[] */
    protected $lines;

    /**
     * @return int|string
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * @param int|string $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return DateType
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param DateType $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * @return DateType
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * @param DateType $glPostingDate
     */
    public function setGlPostingDate($glPostingDate)
    {
        $this->glPostingDate = $glPostingDate;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return int|string
     */
    public function getSummaryRecordNo()
    {
        return $this->summaryRecordNo;
    }

    /**
     * @param int|string $summaryRecordNo
     */
    public function setSummaryRecordNo($summaryRecordNo)
    {
        $this->summaryRecordNo = $summaryRecordNo;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @param string $baseCurrency
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * @return DateType
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * @param DateType $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        $this->exchangeRateDate = $exchangeRateDate;
    }

    /**
     * @return float
     */
    public function getExchangeRateValue()
    {
        return $this->exchangeRateValue;
    }

    /**
     * @param float $exchangeRateValue
     */
    public function setExchangeRateValue($exchangeRateValue)
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

    /**
     * @return string
     */
    public function getExchangeRateType()
    {
        return $this->exchangeRateType;
    }

    /**
     * @param string $exchangeRateType
     */
    public function setExchangeRateType($exchangeRateType)
    {
        $this->exchangeRateType = $exchangeRateType;
    }

    /**
     * @return boolean
     */
    public function isDoNotPostToGL()
    {
        return $this->doNotPostToGL;
    }

    /**
     * @param boolean $doNotPostToGL
     */
    public function setDoNotPostToGL($doNotPostToGL)
    {
        $this->doNotPostToGL = $doNotPostToGL;
    }

    /**
     * @return string
     */
    public function getAdjustmentNumber()
    {
        return $this->adjustmentNumber;
    }

    /**
     * @param string $adjustmentNumber
     */
    public function setAdjustmentNumber($adjustmentNumber)
    {
        $this->adjustmentNumber = $adjustmentNumber;
    }

    /**
     * @return AbstractArAdjustmentLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractArAdjustmentLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

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