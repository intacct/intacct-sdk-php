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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Functions\AbstractFunction;
use InvalidArgumentException;

abstract class AbstractReimbursementRequest extends AbstractFunction
{

    /** @var array */
    const PAYMENT_METHODS = [
        'Printed Check',
        'Cash',
        'EFT',
        'ACH',
    ];

    /** @var string */
    const PAYMENT_METHOD_CHECK = 'Printed Check';

    /** @var string */
    const PAYMENT_METHOD_CASH = 'Cash';

    /** @var string */
    const PAYMENT_METHOD_RECORD_TRANSFER = 'EFT';

    /** @var string */
    const PAYMENT_METHOD_ACH = 'ACH';

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $paymentMethod;

    /** @var string */
    protected $bankAccountId;

    /** @var string */
    protected $employeeId;

    /** @var string */
    protected $mergeOption;

    /** @var \DateTime */
    protected $paymentDate;

    /** @var string */
    protected $documentNo;

    /** @var string */
    protected $memo;

    /** @var string */
    protected $notificationContactName;

    /** @var ReimbursementRequestItem[] */
    protected $applyToTransactions  = [];

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
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
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
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
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
     * @return ReimbursementRequestItem[]
     */
    public function getApplyToTransactions()
    {
        return $this->applyToTransactions;
    }

    /**
     * @param ReimbursementRequestItem[] $applyToTransactions
     */
    public function setApplyToTransactions($applyToTransactions)
    {
        $this->applyToTransactions = $applyToTransactions;
    }
}
