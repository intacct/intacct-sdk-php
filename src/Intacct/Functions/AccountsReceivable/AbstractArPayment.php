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

use Intacct\Functions\AbstractFunction;
use InvalidArgumentException;

abstract class AbstractArPayment extends AbstractFunction
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

    /** @var string|int */
    protected $summaryRecordNo;

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

    /** @var \DateTime */
    protected $receivedDate;

    /** @var float|string */
    protected $transactionPaymentAmount;

    /** @var float|string */
    protected $basePaymentAmount;

    /** @var \DateTime */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var string */
    protected $creditCardType;

    /** @var string */
    protected $authorizationCode;

    /** @var string */
    protected $overpaymentLocationId;

    /** @var string */
    protected $overpaymentDepartmentId;

    /** @var string */
    protected $referenceNumber;

    /** @var ArPaymentItem[] */
    protected $applyToTransactions = [];

    /**
     * Get record number
     *
     * @return int|string
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * Set record number
     *
     * @param int|string $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
    }

    /**
     * Get payment method
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set payment method
     *
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
     * Get Summary Record No (Batch Key)
     *
     * @return int|string
     */
    public function getSummaryRecordNo()
    {
        return $this->summaryRecordNo;
    }

    /**
     * Set Summary Record No (Batch Key)
     *
     * @param string|int $summaryRecordNo
     */
    public function setSummaryRecordNo($summaryRecordNo)
    {
        $this->summaryRecordNo = $summaryRecordNo;
    }

    /**
     * Get bank account ID
     *
     * @return string
     */
    public function getBankAccountId()
    {
        return $this->bankAccountId;
    }

    /**
     * Set bank account ID
     *
     * @param string $bankAccountId
     */
    public function setBankAccountId($bankAccountId)
    {
        $this->bankAccountId = $bankAccountId;
    }

    /**
     * Get undeposited funds GL account number
     *
     * @return string
     */
    public function getUndepositedFundsGlAccountNo()
    {
        return $this->undepositedFundsGlAccountNo;
    }

    /**
     * Set undeposited funds GL account number
     *
     * @param string $undepositedFundsGlAccountNo
     */
    public function setUndepositedFundsGlAccountNo($undepositedFundsGlAccountNo)
    {
        $this->undepositedFundsGlAccountNo = $undepositedFundsGlAccountNo;
    }

    /**
     * Get transaction currency
     *
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * Set transaction currency
     *
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * Get base currency
     *
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * Set base currency
     *
     * @param string $baseCurrency
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * Get customer ID
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customer ID
     *
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Get received date
     *
     * @return \DateTime
     */
    public function getReceivedDate()
    {
        return $this->receivedDate;
    }

    /**
     * Set received date
     *
     * @param \DateTime $receivedDate
     */
    public function setReceivedDate($receivedDate)
    {
        $this->receivedDate = $receivedDate;
    }

    /**
     * Get transaction payment amount
     *
     * @return float|string
     */
    public function getTransactionPaymentAmount()
    {
        return $this->transactionPaymentAmount;
    }

    /**
     * Set transaction payment amount
     *
     * @param float|string $transactionPaymentAmount
     */
    public function setTransactionPaymentAmount($transactionPaymentAmount)
    {
        $this->transactionPaymentAmount = $transactionPaymentAmount;
    }

    /**
     * Get base payment amount
     *
     * @return float|string
     */
    public function getBasePaymentAmount()
    {
        return $this->basePaymentAmount;
    }

    /**
     * Set base payment amount
     *
     * @param float|string $basePaymentAmount
     */
    public function setBasePaymentAmount($basePaymentAmount)
    {
        $this->basePaymentAmount = $basePaymentAmount;
    }

    /**
     * Get exchange rate date
     *
     * @return \DateTime
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * Set exchange rate date
     *
     * @param \DateTime $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        $this->exchangeRateDate = $exchangeRateDate;
    }

    /**
     * Get exchange rate value
     *
     * @return float
     */
    public function getExchangeRateValue()
    {
        return $this->exchangeRateValue;
    }

    /**
     * Set exchange rate value
     *
     * @param float $exchangeRateValue
     */
    public function setExchangeRateValue($exchangeRateValue)
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

    /**
     * Get exchange rate type
     *
     * @return string
     */
    public function getExchangeRateType()
    {
        return $this->exchangeRateType;
    }

    /**
     * Set exchange rate type
     *
     * @param string $exchangeRateType
     */
    public function setExchangeRateType($exchangeRateType)
    {
        $this->exchangeRateType = $exchangeRateType;
    }

    /**
     * @return string
     */
    public function getCreditCardType()
    {
        return $this->creditCardType;
    }

    /**
     * @param string $creditCardType
     */
    public function setCreditCardType($creditCardType)
    {
        $this->creditCardType = $creditCardType;
    }

    /**
     * Get authorization code
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * Set authorization code
     *
     * @param string $authorizationCode
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * Get overpayment location ID
     *
     * @return string
     */
    public function getOverpaymentLocationId()
    {
        return $this->overpaymentLocationId;
    }

    /**
     * Set overpayment location ID
     *
     * @param string $overpaymentLocationId
     */
    public function setOverpaymentLocationId($overpaymentLocationId)
    {
        $this->overpaymentLocationId = $overpaymentLocationId;
    }

    /**
     * Get overpayment department ID
     *
     * @return string
     */
    public function getOverpaymentDepartmentId()
    {
        return $this->overpaymentDepartmentId;
    }

    /**
     * Set overpayment department ID
     *
     * @param string $overpaymentDepartmentId
     */
    public function setOverpaymentDepartmentId($overpaymentDepartmentId)
    {
        $this->overpaymentDepartmentId = $overpaymentDepartmentId;
    }

    /**
     * Get reference number
     *
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * Set reference number
     *
     * @param string $referenceNumber
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * Get apply to transactions
     *
     * @return ArPaymentItem[]
     */
    public function getApplyToTransactions()
    {
        return $this->applyToTransactions;
    }

    /**
     * Set apply to transactions
     *
     * @param ArPaymentItem[] $applyToTransactions
     */
    public function setApplyToTransactions($applyToTransactions)
    {
        $this->applyToTransactions = $applyToTransactions;
    }
}
