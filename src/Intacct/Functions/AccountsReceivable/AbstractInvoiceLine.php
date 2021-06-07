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

use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractInvoiceLine
{

    use CustomFieldsTrait;

    /** @var string */
    protected $accountLabel;

    /** @var string */
    protected $glAccountNumber;

    /** @var string */
    protected $offsetGLAccountNumber;

    /** @var float */
    protected $transactionAmount;

    /** @var string */
    protected $allocationId;

    /** @var string */
    protected $memo;

    /** @var string */
    protected $key;

    /** @var float */
    protected $totalPaid;

    /** @var float */
    protected $totalDue;

    /** @var string */
    protected $revRecTemplateId;

    /** @var string */
    protected $deferredRevGlAccountNo;

    /** @var \DateTime */
    protected $revRecStartDate;

    /** @var \DateTime */
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

    /** @var AbstractInvoiceLineTaxEntries[] */
    protected $taxEntry = [];

    /**
     * Get account label
     *
     * @return string
     */
    public function getAccountLabel()
    {
        return $this->accountLabel;
    }

    /**
     * Set account label
     *
     * @param string $accountLabel
     */
    public function setAccountLabel($accountLabel)
    {
        $this->accountLabel = $accountLabel;
    }

    /**
     * Get GL account number
     *
     * @return string
     */
    public function getGlAccountNumber()
    {
        return $this->glAccountNumber;
    }

    /**
     * Set GL account number
     *
     * @param string $glAccountNumber
     */
    public function setGlAccountNumber($glAccountNumber)
    {
        $this->glAccountNumber = $glAccountNumber;
    }

    /**
     * Get offset GL account number
     *
     * @return string
     */
    public function getOffsetGLAccountNumber()
    {
        return $this->offsetGLAccountNumber;
    }

    /**
     * Set offset GL account number
     *
     * @param string $offsetGLAccountNumber
     */
    public function setOffsetGLAccountNumber($offsetGLAccountNumber)
    {
        $this->offsetGLAccountNumber = $offsetGLAccountNumber;
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
     * Get allocation ID
     *
     * @return string
     */
    public function getAllocationId()
    {
        return $this->allocationId;
    }

    /**
     * Set allocation ID
     *
     * @param string $allocationId
     */
    public function setAllocationId($allocationId)
    {
        $this->allocationId = $allocationId;
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
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get total paid
     *
     * @return float|string
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * Set total paid
     *
     * @param float|string $totalPaid
     */
    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;
    }

    /**
     * Get total due
     *
     * @return float|string
     */
    public function getTotalDue()
    {
        return $this->totalDue;
    }

    /**
     * Set total due
     *
     * @param float|string $totalDue
     */
    public function setTotalDue($totalDue)
    {
        $this->totalDue = $totalDue;
    }

    /**
     * Get revenue recognition template ID
     *
     * @return string
     */
    public function getRevRecTemplateId()
    {
        return $this->revRecTemplateId;
    }

    /**
     * Set revenue recognition template ID
     *
     * @param string $revRecTemplateId
     */
    public function setRevRecTemplateId($revRecTemplateId)
    {
        $this->revRecTemplateId = $revRecTemplateId;
    }

    /**
     * Get deferred revenue GL account number
     *
     * @return string
     */
    public function getDeferredRevGlAccountNo()
    {
        return $this->deferredRevGlAccountNo;
    }

    /**
     * Set deferred revenue GL account number
     *
     * @param string $deferredRevGlAccountNo
     */
    public function setDeferredRevGlAccountNo($deferredRevGlAccountNo)
    {
        $this->deferredRevGlAccountNo = $deferredRevGlAccountNo;
    }

    /**
     * Get revenue recognition start date
     *
     * @return \DateTime
     */
    public function getRevRecStartDate()
    {
        return $this->revRecStartDate;
    }

    /**
     * Set revenue recognition start date
     *
     * @param \DateTime $revRecStartDate
     */
    public function setRevRecStartDate($revRecStartDate)
    {
        $this->revRecStartDate = $revRecStartDate;
    }

    /**
     * Get revenue recognition end date
     *
     * @return \DateTime
     */
    public function getRevRecEndDate()
    {
        return $this->revRecEndDate;
    }

    /**
     * Set revenue recognition end date
     *
     * @param \DateTime $revRecEndDate
     */
    public function setRevRecEndDate($revRecEndDate)
    {
        $this->revRecEndDate = $revRecEndDate;
    }

    /**
     * Get department ID
     *
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * Set department ID
     *
     * @param string $departmentId
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * Get location ID
     *
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * Set location ID
     *
     * @param string $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * Get project ID
     *
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set project ID
     *
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
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
     * Get employee ID
     *
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Set employee ID
     *
     * @param string $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * Get item ID
     *
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set item ID
     *
     * @param string $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * Get class ID
     *
     * @return string
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * Set class ID
     *
     * @param string $classId
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;
    }

    /**
     * Get contract ID
     *
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * Set contract ID
     *
     * @param string $contractId
     */
    public function setContractId($contractId)
    {
        $this->contractId = $contractId;
    }

    /**
     * Get warehouse ID
     *
     * @return string
     */
    public function getWarehouseId()
    {
        return $this->warehouseId;
    }

    /**
     * Set warehouse ID
     *
     * @param string $warehouseId
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;
    }

    /**
     * @return AbstractInvoiceLineTaxEntries[]
     */
    public function getTaxEntry(): array
    {
        return $this->taxEntry;
    }

    /**
     * @param AbstractInvoiceLineTaxEntries[] $taxEntry
     */
    public function setTaxEntry(array $taxEntry): void
    {
        $this->taxEntry = $taxEntry;
    }

    abstract public function writeXml(XMLWriter &$xml);
}
