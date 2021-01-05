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
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractExpenseReport extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int */
    protected $recordNo;

    /** @var \DateTime */
    protected $transactionDate;

    /** @var string */
    protected $employeeId;

    /** @var string */
    protected $expenseReportNumber;

    /** @var \DateTime */
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

    /** @var AbstractExpenseReportLine[] */
    protected $lines = [];

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
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param \DateTime $transactionDate
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
     * @return \DateTime
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * @param \DateTime $glPostingDate
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
    public function getReasonForExpense()
    {
        return $this->reasonForExpense;
    }

    /**
     * @param string $reasonForExpense
     */
    public function setReasonForExpense($reasonForExpense)
    {
        $this->reasonForExpense = $reasonForExpense;
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
     * @return AbstractExpenseReportLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractExpenseReportLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
