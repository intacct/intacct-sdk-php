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

namespace Intacct\Functions\OrderEntry;

use Intacct\Functions\InventoryControl\AbstractTransactionItemDetail;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractOrderEntryTransactionLine
{

    use CustomFieldsTrait;

    /** @var string */
    protected $bundleNumber;

    /** @var string */
    protected $itemId;

    /** @var string */
    protected $itemDescription;

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $warehouseId;

    /** @var string */
    protected $quantity;

    /** @var string */
    protected $unit;

    /** @var string */
    protected $discountPercent;

    /** @var string */
    protected $price;

    /** @var string */
    protected $discountSurchargeMemo;

    /** @var string */
    protected $memo;

    /** @var string */
    protected $revRecTemplate;

    /** @var \DateTime */
    protected $revRecStartDate;

    /** @var \DateTime */
    protected $revRecEndDate;

    /** @var string */
    protected $renewalMacro;

    /** @var AbstractFulfillmentStatus|AbstractKitStatus */
    protected $fulfillmentStatus;

    /** @var string */
    protected $taskNumber;

    /** @var string */
    protected $billingTemplate;

    /** @var AbstractTransactionItemDetail[] */
    protected $itemDetails = [];

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
    protected $classId;

    /** @var string */
    protected $contractId;

    /**
     * @return string
     */
    public function getBundleNumber()
    {
        return $this->bundleNumber;
    }

    /**
     * @param string $bundleNumber
     */
    public function setBundleNumber($bundleNumber)
    {
        $this->bundleNumber = $bundleNumber;
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
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * @param string $itemDescription
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }

    /**
     * @return bool
     */
    public function isTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param bool $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
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

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

    /**
     * @param string $discountPercent
     */
    public function setDiscountPercent($discountPercent)
    {
        $this->discountPercent = $discountPercent;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDiscountSurchargeMemo()
    {
        return $this->discountSurchargeMemo;
    }

    /**
     * @param string $discountSurchargeMemo
     */
    public function setDiscountSurchargeMemo($discountSurchargeMemo)
    {
        $this->discountSurchargeMemo = $discountSurchargeMemo;
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
    public function getRevRecTemplate()
    {
        return $this->revRecTemplate;
    }

    /**
     * @param string $revRecTemplate
     */
    public function setRevRecTemplate($revRecTemplate)
    {
        $this->revRecTemplate = $revRecTemplate;
    }

    /**
     * @return \DateTime
     */
    public function getRevRecStartDate()
    {
        return $this->revRecStartDate;
    }

    /**
     * @param \DateTime $revRecStartDate
     */
    public function setRevRecStartDate($revRecStartDate)
    {
        $this->revRecStartDate = $revRecStartDate;
    }

    /**
     * @return \DateTime
     */
    public function getRevRecEndDate()
    {
        return $this->revRecEndDate;
    }

    /**
     * @param \DateTime $revRecEndDate
     */
    public function setRevRecEndDate($revRecEndDate)
    {
        $this->revRecEndDate = $revRecEndDate;
    }

    /**
     * @return string
     */
    public function getRenewalMacro()
    {
        return $this->renewalMacro;
    }

    /**
     * @param string $renewalMacro
     */
    public function setRenewalMacro($renewalMacro)
    {
        $this->renewalMacro = $renewalMacro;
    }

    /**
     * @return AbstractFulfillmentStatus|AbstractKitStatus
     */
    public function getFulfillmentStatus()
    {
        return $this->fulfillmentStatus;
    }

    /**
     * @param AbstractFulfillmentStatus|AbstractKitStatus $fulfillmentStatus
     */
    public function setFulfillmentStatus($fulfillmentStatus)
    {
        $this->fulfillmentStatus = $fulfillmentStatus;
    }

    /**
     * @return string
     */
    public function getTaskNumber()
    {
        return $this->taskNumber;
    }

    /**
     * @param string $taskNumber
     */
    public function setTaskNumber($taskNumber)
    {
        $this->taskNumber = $taskNumber;
    }

    /**
     * @return string
     */
    public function getBillingTemplate()
    {
        return $this->billingTemplate;
    }

    /**
     * @param string $billingTemplate
     */
    public function setBillingTemplate($billingTemplate)
    {
        $this->billingTemplate = $billingTemplate;
    }

    /**
     * @return AbstractTransactionItemDetail[]
     */
    public function getItemDetails()
    {
        return $this->itemDetails;
    }

    /**
     * @param AbstractTransactionItemDetail[] $itemDetails
     */
    public function setItemDetails($itemDetails)
    {
        $this->itemDetails = $itemDetails;
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

    abstract public function writeXml(XMLWriter &$xml);
}
