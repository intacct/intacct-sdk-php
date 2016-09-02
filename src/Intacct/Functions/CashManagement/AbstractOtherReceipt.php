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

abstract class AbstractOtherReceipt extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var DateType */
    protected $receiptDate;

    /** @var string */
    protected $payer;

    /** @var string */
    protected $paymentMethod;

    /** @var DateType */
    protected $transactionDate;

    /** @var string */
    protected $transactionNo;

    /** @var string */
    protected $description;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $bankAccountId;

    /** @var DateType */
    protected $depositDate;

    /** @var string */
    protected $undepositedFundsGlAccountNo;

    /** @var string */
    protected $transactionCurrency;

    /** @var DateType */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var AbstractOtherReceiptLine[] */
    protected $lines;

    /**
     * @return DateType
     */
    public function getReceiptDate()
    {
        return $this->receiptDate;
    }

    /**
     * @param DateType $receiptDate
     */
    public function setReceiptDate($receiptDate)
    {
        $this->receiptDate = $receiptDate;
    }

    /**
     * @return string
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param string $payer
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
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
    public function getTransactionNo()
    {
        return $this->transactionNo;
    }

    /**
     * @param string $transactionNo
     */
    public function setTransactionNo($transactionNo)
    {
        $this->transactionNo = $transactionNo;
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
    public function getBankAccountId()
    {
        return $this->bankAccountId;
    }

    /**
     * @param string $bankAccountId
     */
    public function setBankAccountId($bankAccountId)
    {
        $this->bankAccountId = $bankAccountId;
    }

    /**
     * @return DateType
     */
    public function getDepositDate()
    {
        return $this->depositDate;
    }

    /**
     * @param DateType $depositDate
     */
    public function setDepositDate($depositDate)
    {
        $this->depositDate = $depositDate;
    }

    /**
     * @return string
     */
    public function getUndepositedFundsGlAccountNo()
    {
        return $this->undepositedFundsGlAccountNo;
    }

    /**
     * @param string $undepositedFundsGlAccountNo
     */
    public function setUndepositedFundsGlAccountNo($undepositedFundsGlAccountNo)
    {
        $this->undepositedFundsGlAccountNo = $undepositedFundsGlAccountNo;
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
     * @return AbstractOtherReceiptLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractOtherReceiptLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
