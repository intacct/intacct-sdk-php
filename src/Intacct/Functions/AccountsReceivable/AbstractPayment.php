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
use InvalidArgumentException;

abstract class AbstractPayment extends AbstractFunction
{

    /** @var string */
    const PAYMENT_METHOD_CHECK = 'Printed Check';

    /** @var string */
    const PAYMENT_METHOD_CASH = 'Cash';

    /** @var string */
    const PAYMENT_METHOD_RECORD_TRANSFER = 'EFT';

    /** @var string */
    const PAYMENT_METHOD_CREDIT_CARD = 'Credit Card';

    /** @var string */
    const PAYMENT_METHOD_ONLINE = 'Online';

    /** @var string */
    const PAYMENT_METHOD_ONLINE_CREDIT_CARD = 'Online Charge Card';

    /** @var string */
    const PAYMENT_METHOD_ONLINE_ACH_DEBIT = 'Online ACH Debit';

    /** @var array */
    const PAYMENT_METHODS = [
        'Printed Check',
        'Cash',
        'EFT',
        'Credit Card',
        'Online',
        //'Online Charge Card',
        //'Online ACH Debit',
    ];

    /** @var int|string */
    protected $recordNo;

    /** @var string */
    protected $paymentMethod;

    /** @var string */
    protected $bankAccountId;

    /** @var string */
    protected $undepositedFundsGlAccountNo;

    /** @var string */
    protected $transactionCurrency;

    /** @var string */
    protected $baseCurrency;

    /** @var string */
    protected $customerId;

    /** @var DateType */
    protected $receivedDate;

    /** @var float|string */
    protected $transactionPaymentAmount;

    /** @var float|string */
    protected $basePaymentAmount;

    /** @var DateType */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var string */
    protected $authorizationCode;

    /** @var string */
    protected $overpaymentLocationId;

    /** @var string */
    protected $overpaymentDepartmentId;

    /** @var string */
    protected $referenceNumber;

    /** @var PaymentItem[] */
    protected $applyToTransactions;

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
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     * @throws InvalidArgumentException
     */
    public function setPaymentMethod($paymentMethod)
    {
        if (!in_array($paymentMethod, static::PAYMENT_METHODS)) {
            throw new InvalidArgumentException('Payment method is not valid');
        }
        $this->paymentMethod = $paymentMethod;
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
    public function getReceivedDate()
    {
        return $this->receivedDate;
    }

    /**
     * @param DateType $receivedDate
     */
    public function setReceivedDate($receivedDate)
    {
        $this->receivedDate = $receivedDate;
    }

    /**
     * @return float|string
     */
    public function getTransactionPaymentAmount()
    {
        return $this->transactionPaymentAmount;
    }

    /**
     * @param float|string $transactionPaymentAmount
     */
    public function setTransactionPaymentAmount($transactionPaymentAmount)
    {
        $this->transactionPaymentAmount = $transactionPaymentAmount;
    }

    /**
     * @return float|string
     */
    public function getBasePaymentAmount()
    {
        return $this->basePaymentAmount;
    }

    /**
     * @param float|string $basePaymentAmount
     */
    public function setBasePaymentAmount($basePaymentAmount)
    {
        $this->basePaymentAmount = $basePaymentAmount;
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
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $authorizationCode
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return string
     */
    public function getOverpaymentLocationId()
    {
        return $this->overpaymentLocationId;
    }

    /**
     * @param string $overpaymentLocationId
     */
    public function setOverpaymentLocationId($overpaymentLocationId)
    {
        $this->overpaymentLocationId = $overpaymentLocationId;
    }

    /**
     * @return string
     */
    public function getOverpaymentDepartmentId()
    {
        return $this->overpaymentDepartmentId;
    }

    /**
     * @param string $overpaymentDepartmentId
     */
    public function setOverpaymentDepartmentId($overpaymentDepartmentId)
    {
        $this->overpaymentDepartmentId = $overpaymentDepartmentId;
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
     * @return PaymentItem[]
     */
    public function getApplyToTransactions()
    {
        return $this->applyToTransactions;
    }

    /**
     * @param PaymentItem[] $applyToTransactions
     */
    public function setApplyToTransactions($applyToTransactions)
    {
        $this->applyToTransactions = $applyToTransactions;
    }
}
