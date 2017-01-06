<?php

/**
 * Copyright 2017 Intacct Corporation.
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

use Intacct\FieldTypes\DateType;
use Intacct\Functions\AbstractFunction;
use InvalidArgumentException;

abstract class AbstractApPaymentRequest extends AbstractFunction
{

    /** @var array */
    const PAYMENT_METHODS = [
        'Printed Check',
        'Cash',
        'EFT',
        'Charge Card',
        'ACH',
        // TODO: Add Amex, WF, etc
    ];

    /** @var string */
    const PAYMENT_METHOD_CHECK = 'Printed Check';

    /** @var string */
    const PAYMENT_METHOD_CASH = 'Cash';

    /** @var string */
    const PAYMENT_METHOD_RECORD_TRANSFER = 'EFT';

    /** @var string */
    const PAYMENT_METHOD_CHARGE_CARD = 'Charge Card';

    /** @var string */
    const PAYMENT_METHOD_ACH = 'ACH';

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $paymentMethod;

    /** @var string */
    protected $bankAccountId;

    /** @var string */
    protected $chargeCardId;

    /** @var string */
    protected $vendorId;

    /** @var string */
    protected $mergeOption;

    /** @var bool */
    protected $groupPayments;

    /** @var DateType */
    protected $paymentDate;

    /** @var float|string */
    protected $transactionAmount;

    /** @var string */
    protected $documentNo;

    /** @var string */
    protected $memo;

    /** @var string */
    protected $notificationContactName;

    /** @var ApPaymentRequestItem[] */
    protected $applyToTransactions;

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
            throw new InvalidArgumentException('Payment Method is not valid');
        }
        $this->paymentMethod = $paymentMethod;
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
     * Get charge card ID
     *
     * @return string
     */
    public function getChargeCardId()
    {
        return $this->chargeCardId;
    }

    /**
     * Set charge card ID
     *
     * @param string $chargeCardId
     */
    public function setChargeCardId($chargeCardId)
    {
        $this->chargeCardId = $chargeCardId;
    }

    /**
     * Get vendor ID
     *
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * Set vendor ID
     *
     * @param string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * Get merge option
     *
     * @return string
     */
    public function getMergeOption()
    {
        return $this->mergeOption;
    }

    /**
     * Set merge option
     *
     * @param string $mergeOption
     * @todo add merge options
     */
    public function setMergeOption($mergeOption)
    {
        $this->mergeOption = $mergeOption;
    }

    /**
     * Get group payments
     *
     * @return boolean
     */
    public function isGroupPayments()
    {
        return $this->groupPayments;
    }

    /**
     * Set group payments
     *
     * @param boolean $groupPayments
     */
    public function setGroupPayments($groupPayments)
    {
        $this->groupPayments = $groupPayments;
    }

    /**
     * Get payment date
     *
     * @return DateType
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set payment date
     *
     * @param DateType $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * Get transaction amount
     *
     * @return float|string
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * Set transaction amount
     *
     * @param float|string $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->transactionAmount = $transactionAmount;
    }

    /**
     * Get document number
     *
     * @return string
     */
    public function getDocumentNo()
    {
        return $this->documentNo;
    }

    /**
     * Set document number
     *
     * @param string $documentNo
     */
    public function setDocumentNo($documentNo)
    {
        $this->documentNo = $documentNo;
    }

    /**
     * Get memo
     *
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set memo
     *
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * Get notification contact name
     *
     * @return string
     */
    public function getNotificationContactName()
    {
        return $this->notificationContactName;
    }

    /**
     * Set notification contact name
     *
     * @param string $notificationContactName
     */
    public function setNotificationContactName($notificationContactName)
    {
        $this->notificationContactName = $notificationContactName;
    }

    /**
     * Get apply to transactions
     *
     * @return ApPaymentRequestItem[]
     */
    public function getApplyToTransactions()
    {
        return $this->applyToTransactions;
    }

    /**
     * Set apply to transactions
     *
     * @param ApPaymentRequestItem[] $applyToTransactions
     */
    public function setApplyToTransactions($applyToTransactions)
    {
        $this->applyToTransactions = $applyToTransactions;
    }
}
