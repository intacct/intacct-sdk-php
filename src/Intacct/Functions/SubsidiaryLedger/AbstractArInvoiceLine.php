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
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractArInvoiceLine
{

    use CustomFieldsTrait;

    /** @var string */
    protected $accountLabel;

    /** @var string */
    protected $glAccountNumber;

    /** @var string */
    protected $offsetGLAccountNumber;

    /** @var string|float */
    protected $transactionAmount;

    /** @var string */
    protected $allocationId;

    /** @var string */
    protected $memo;

    /** @var string */
    protected $key;

    /** @var string|float */
    protected $totalPaid;

    /** @var string|float */
    protected $totalDue;

    /** @var string */
    protected $revRecTemplateId;

    /** @var string */
    protected $deferredRevGlAccountNo;

    /** @var DateType */
    protected $revRecStartDate;

    /** @var DateType */
    protected $revRecEndDate;

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
    public function getAccountLabel()
    {
        return $this->accountLabel;
    }

    /**
     * @param string $accountLabel
     */
    public function setAccountLabel($accountLabel)
    {
        $this->accountLabel = $accountLabel;
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
     * @return string
     */
    public function getOffsetGLAccountNumber()
    {
        return $this->offsetGLAccountNumber;
    }

    /**
     * @param string $offsetGLAccountNumber
     */
    public function setOffsetGLAccountNumber($offsetGLAccountNumber)
    {
        $this->offsetGLAccountNumber = $offsetGLAccountNumber;
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
    public function getAllocationId()
    {
        return $this->allocationId;
    }

    /**
     * @param string $allocationId
     */
    public function setAllocationId($allocationId)
    {
        $this->allocationId = $allocationId;
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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return float|string
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * @param float|string $totalPaid
     */
    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;
    }

    /**
     * @return float|string
     */
    public function getTotalDue()
    {
        return $this->totalDue;
    }

    /**
     * @param float|string $totalDue
     */
    public function setTotalDue($totalDue)
    {
        $this->totalDue = $totalDue;
    }

    /**
     * @return string
     */
    public function getRevRecTemplateId()
    {
        return $this->revRecTemplateId;
    }

    /**
     * @param string $revRecTemplateId
     */
    public function setRevRecTemplateId($revRecTemplateId)
    {
        $this->revRecTemplateId = $revRecTemplateId;
    }

    /**
     * @return string
     */
    public function getDeferredRevGlAccountNo()
    {
        return $this->deferredRevGlAccountNo;
    }

    /**
     * @param string $deferredRevGlAccountNo
     */
    public function setDeferredRevGlAccountNo($deferredRevGlAccountNo)
    {
        $this->deferredRevGlAccountNo = $deferredRevGlAccountNo;
    }

    /**
     * @return DateType
     */
    public function getRevRecStartDate()
    {
        return $this->revRecStartDate;
    }

    /**
     * @param DateType $revRecStartDate
     */
    public function setRevRecStartDate($revRecStartDate)
    {
        $this->revRecStartDate = $revRecStartDate;
    }

    /**
     * @return DateType
     */
    public function getRevRecEndDate()
    {
        return $this->revRecEndDate;
    }

    /**
     * @param DateType $revRecEndDate
     */
    public function setRevRecEndDate($revRecEndDate)
    {
        $this->revRecEndDate = $revRecEndDate;
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
}
