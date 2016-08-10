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

abstract class AbstractEeAdjustment extends AbstractFunction
{

    //Current schema does not allow custom fields
    //use CustomFieldsTrait;

    /** @var Date */
    protected $transactionDate;

    /** @var string */
    protected $employeeId;

    /** @var string */
    protected $expenseReportNumber;

    /** @var string */
    protected $expenseAdjustmentNumber;

    /** @var Date */
    protected $glPostingDate;

    /** @var string|int */
    protected $summaryRecordNo;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $action;

    /** @var string */
    protected $baseCurrency;

    /** @var string */
    protected $reimbursementCurrency;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $reasonForExpense;

    /** @var string */
    protected $description;

    /** @var string */
    protected $memo;

    /** @var array */
    protected $lines;

    /**
     * @return Date
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param Date $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
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
    public function getExpenseReportNumber()
    {
        return $this->expenseReportNumber;
    }

    /**
     * @param string $expenseReportNumber
     */
    public function setExpenseReportNumber($expenseReportNumber)
    {
        $this->expenseReportNumber = $expenseReportNumber;
    }

    /**
     * @return string
     */
    public function getExpenseAdjustmentNumber()
    {
        return $this->expenseAdjustmentNumber;
    }

    /**
     * @param string $expenseAdjustmentNumber
     */
    public function setExpenseAdjustmentNumber($expenseAdjustmentNumber)
    {
        $this->expenseAdjustmentNumber = $expenseAdjustmentNumber;
    }

    /**
     * @return Date
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * @param Date $glPostingDate
     */
    public function setGlPostingDate($glPostingDate)
    {
        $this->glPostingDate = $glPostingDate;
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
    public function getReimbursementCurrency()
    {
        return $this->reimbursementCurrency;
    }

    /**
     * @param string $reimbursementCurrency
     */
    public function setReimbursementCurrency($reimbursementCurrency)
    {
        $this->reimbursementCurrency = $reimbursementCurrency;
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
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param array $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
