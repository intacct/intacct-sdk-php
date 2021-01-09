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

namespace Intacct\Functions\Projects;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractTimesheetEntry extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int|string */
    protected $lineRecordNo;

    /** @var \DateTime */
    protected $entryDate;

    /** @var int|float|string */
    protected $quantity;

    /** @var string */
    protected $description;

    /** @var string */
    protected $notes;

    /** @var int|string */
    protected $taskRecordNo;

    /** @var string */
    protected $timeTypeName;

    /** @var bool */
    protected $billable;

    /** @var float|int|string */
    protected $overrideBillingRate;

    /** @var float|int|string */
    protected $overrideLaborCostRate;

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
    protected $itemId;

    /** @var string */
    protected $classId;

    /** @var string */
    protected $contractId;

    /** @var string */
    protected $warehouseId;

    /**
     * @return int|string
     */
    public function getLineRecordNo()
    {
        return $this->lineRecordNo;
    }

    /**
     * @param int|string $lineRecordNo
     */
    public function setLineRecordNo($lineRecordNo): void
    {
        $this->lineRecordNo = $lineRecordNo;
    }

    /**
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * @param \DateTime $entryDate
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
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
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return int|string
     */
    public function getTaskRecordNo()
    {
        return $this->taskRecordNo;
    }

    /**
     * @param int|string $taskRecordNo
     */
    public function setTaskRecordNo($taskRecordNo)
    {
        $this->taskRecordNo = $taskRecordNo;
    }

    /**
     * @return string
     */
    public function getTimeTypeName()
    {
        return $this->timeTypeName;
    }

    /**
     * @param string $timeTypeName
     */
    public function setTimeTypeName($timeTypeName)
    {
        $this->timeTypeName = $timeTypeName;
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
     * @return float|int|string
     */
    public function getOverrideBillingRate()
    {
        return $this->overrideBillingRate;
    }

    /**
     * @param float|int|string $overrideBillingRate
     */
    public function setOverrideBillingRate($overrideBillingRate)
    {
        $this->overrideBillingRate = $overrideBillingRate;
    }

    /**
     * @return float|int|string
     */
    public function getOverrideLaborCostRate()
    {
        return $this->overrideLaborCostRate;
    }

    /**
     * @param float|int|string $overrideLaborCostRate
     */
    public function setOverrideLaborCostRate($overrideLaborCostRate)
    {
        $this->overrideLaborCostRate = $overrideLaborCostRate;
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
