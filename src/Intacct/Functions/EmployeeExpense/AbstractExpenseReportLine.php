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

use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractExpenseReportLine
{

    use CustomFieldsTrait;

    /** @var string */
    protected $expenseType;

    /** @var string */
    protected $glAccountNumber;

    /** @var float */
    protected $reimbursementAmount;

    /** @var string */
    protected $paymentTypeName;

    /** @var bool */
    protected $form1099;

    /** @var string */
    protected $form1099type;

    /** @var string */
    protected $form1099box;

    /** @var string */
    protected $paidTo;

    /** @var string */
    protected $paidFor;

    /** @var \DateTime */
    protected $expenseDate;

    /** @var int|float|string */
    protected $quantity;

    /** @var int|float|string */
    protected $unitRate;

    /** @var string */
    protected $transactionCurrency;

    /** @var float|string */
    protected $transactionAmount;

    /** @var \DateTime */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var bool */
    protected $billable;

    /** @var string */
    protected $departmentId;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $projectId;

    /** @var string */
    protected $customerId;

    /** @var string */
    protected $vendorId;

    /** @var string */
    protected $employeeId;

    /** @var string */
    protected $itemId;

    /** @var string */
    protected $classId;

    /** @var string */
    protected $contractId;

    /** @var string */
    protected $warehouseId;

    /**
     * @return string
     */
    public function getExpenseType()
    {
        return $this->expenseType;
    }

    /**
     * @param string $expenseType
     */
    public function setExpenseType($expenseType)
    {
        $this->expenseType = $expenseType;
    }

    /**
     * @return string
     */
    public function getGlAccountNumber()
    {
        return $this->glAccountNumber;
    }

    /**
     * @param string $glAccountNumber
     */
    public function setGlAccountNumber($glAccountNumber)
    {
        $this->glAccountNumber = $glAccountNumber;
    }

    /**
     * @return float|string
     */
    public function getReimbursementAmount()
    {
        return $this->reimbursementAmount;
    }

    /**
     * @param float|string $reimbursementAmount
     */
    public function setReimbursementAmount($reimbursementAmount)
    {
        $this->reimbursementAmount = $reimbursementAmount;
    }

    /**
     * @return string
     */
    public function getPaymentTypeName()
    {
        return $this->paymentTypeName;
    }

    /**
     * @param string $paymentTypeName
     */
    public function setPaymentTypeName($paymentTypeName)
    {
        $this->paymentTypeName = $paymentTypeName;
    }

    /**
     * @return bool
     */
    public function isForm1099()
    {
        return $this->form1099;
    }

    /**
     * @param bool $form1099
     */
    public function setForm1099($form1099)
    {
        $this->form1099 = $form1099;
    }

    /**
     * @return string
     */
    public function getForm1099type()
    {
        return $this->form1099type;
    }

    /**
     * @param string $form1099type
     */
    public function setForm1099type($form1099type)
    {
        $this->form1099type = $form1099type;
    }

    /**
     * @return string
     */
    public function getForm1099box()
    {
        return $this->form1099box;
    }

    /**
     * @param string $form1099box
     */
    public function setForm1099box($form1099box)
    {
        $this->form1099box = $form1099box;
    }

    /**
     * @return string
     */
    public function getPaidTo()
    {
        return $this->paidTo;
    }

    /**
     * @param string $paidTo
     */
    public function setPaidTo($paidTo)
    {
        $this->paidTo = $paidTo;
    }

    /**
     * @return string
     */
    public function getPaidFor()
    {
        return $this->paidFor;
    }

    /**
     * @param string $paidFor
     */
    public function setPaidFor($paidFor)
    {
        $this->paidFor = $paidFor;
    }

    /**
     * @return \DateTime
     */
    public function getExpenseDate()
    {
        return $this->expenseDate;
    }

    /**
     * @param \DateTime $expenseDate
     */
    public function setExpenseDate($expenseDate)
    {
        $this->expenseDate = $expenseDate;
    }

    /**
     * @return float|int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float|int|string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float|int|string
     */
    public function getUnitRate()
    {
        return $this->unitRate;
    }

    /**
     * @param float|int|string $unitRate
     */
    public function setUnitRate($unitRate)
    {
        $this->unitRate = $unitRate;
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
     * @return \DateTime
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * @param \DateTime $exchangeRateDate
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
     * @return bool
     */
    public function isBillable()
    {
        return $this->billable;
    }

    /**
     * @param bool $billable
     */
    public function setBillable($billable)
    {
        $this->billable = $billable;
    }

    /**
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * @param string $departmentId
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param string $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
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
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return string
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * @param string $classId
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @param string $contractId
     */
    public function setContractId($contractId)
    {
        $this->contractId = $contractId;
    }

    /**
     * @return string
     */
    public function getWarehouseId()
    {
        return $this->warehouseId;
    }

    /**
     * @param string $warehouseId
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;
    }

    abstract public function writeXml(XMLWriter &$xml);
}
