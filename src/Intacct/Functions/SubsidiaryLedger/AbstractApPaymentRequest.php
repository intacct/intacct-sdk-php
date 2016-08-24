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

    /** @var array */
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
            throw new InvalidArgumentException('Payment Method is not valid');
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
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @return string
     */
    public function getMergeOption()
    {
        return $this->mergeOption;
    }

    /**
     * @param string $mergeOption
     */
    public function setMergeOption($mergeOption)
    {
        $this->mergeOption = $mergeOption;
    }

    /**
     * @return boolean
     */
    public function isGroupPayments()
    {
        return $this->groupPayments;
    }

    /**
     * @param boolean $groupPayments
     */
    public function setGroupPayments($groupPayments)
    {
        $this->groupPayments = $groupPayments;
    }

    /**
     * @return DateType
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param DateType $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return float|string
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * @param float|string $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->transactionAmount = $transactionAmount;
    }

    /**
     * @return string
     */
    public function getDocumentNo()
    {
        return $this->documentNo;
    }

    /**
     * @param string $documentNo
     */
    public function setDocumentNo($documentNo)
    {
        $this->documentNo = $documentNo;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * @return string
     */
    public function getNotificationContactName()
    {
        return $this->notificationContactName;
    }

    /**
     * @param string $notificationContactName
     */
    public function setNotificationContactName($notificationContactName)
    {
        $this->notificationContactName = $notificationContactName;
    }

    /**
     * @return array
     */
    public function getApplyToTransactions()
    {
        return $this->applyToTransactions;
    }

    /**
     * @param array $applyToTransactions
     */
    public function setApplyToTransactions($applyToTransactions)
    {
        $this->applyToTransactions = $applyToTransactions;
    }
}
