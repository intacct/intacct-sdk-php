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

namespace Intacct\Functions\CashManagement;

use Intacct\FieldTypes\DateType;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractChargeCardTransaction extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $chargeCardId;

    /** @var DateType */
    protected $transactionDate;

    /** @var string */
    protected $referenceNumber;

    /** @var string */
    protected $payee;

    /** @var string */
    protected $description;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $transactionCurrency;

    /** @var DateType */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var AbstractChargeCardTransactionLine[] */
    protected $lines;

    /**
     * @return int
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * @param int $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
    }

    /**
     * @return string
     */
    public function getChargeCardId()
    {
        return $this->chargeCardId;
    }

    /**
     * @param string $chargeCardId
     */
    public function setChargeCardId($chargeCardId)
    {
        $this->chargeCardId = $chargeCardId;
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
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @param string $referenceNumber
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * @return string
     */
    public function getPayee()
    {
        return $this->payee;
    }

    /**
     * @param string $payee
     */
    public function setPayee($payee)
    {
        $this->payee = $payee;
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
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
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
     * @return AbstractChargeCardTransactionLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractChargeCardTransactionLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
