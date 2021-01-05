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

namespace Intacct\Functions\InventoryControl;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractItem extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $itemId;

    /** @var bool */
    protected $active;

    /** @var string */
    protected $itemName;

    /** @var string */
    protected $produceLineId;

    /** @var string */
    protected $costMethod;

    /** @var string */
    protected $extendedDescription;

    /** @var string */
    protected $salesDescription;

    /** @var string */
    protected $purchasingDescription;

    /** @var string */
    protected $unitOfMeasure;

    /** @var string */
    protected $note;

    /** @var string */
    protected $expenseGlAccountNo;

    /** @var string */
    protected $arGlAccountNo;

    /** @var string */
    protected $apGlAccountNo;

    /** @var string */
    protected $inventoryGlAccountNo;

    /** @var float|int|string */
    protected $shippingWeight;

    /** @var string */
    protected $itemGlGroupName;

    /** @var float|string */
    protected $standardCost;

    /** @var string */
    protected $cogsGlAccountNo;

    /** @var float|string */
    protected $basePrice;

    /** @var string */
    protected $revenueGlAccountNo;

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $itemTaxGroupName;

    /** @var string */
    protected $deferredRevGlAccountNo;

    /** @var string */
    protected $defaultRevRecTemplateId;

    /** @var string */
    protected $vsoeCategory;

    /** @var string */
    protected $vsoeDefaultDeliveryStatus;

    /** @var string */
    protected $vsoeDefaultDeferralStatus;

    /** @var string */
    protected $kitRevenuePosting;

    /** @var string */
    protected $kitPrintFormat;

    /** @var string */
    protected $substituteItemId;

    /** @var bool */
    protected $serialTrackingEnabled;

    /** @var string */
    protected $serialNumberMask;

    /** @var bool */
    protected $lotTrackingEnabled;

    /** @var string */
    protected $lotCategory;

    /** @var bool */
    protected $binTrackingEnabled;

    /** @var bool */
    protected $expTrackingEnabled;

    /** @var string */
    protected $upc;

    /** @var int */
    protected $unitCostPrecisionInventory;

    /** @var int */
    protected $unitCostPrecisionSales;

    /** @var int */
    protected $unitCostPrecisionPurchasing;

    /** @var bool */
    protected $itemStartEndDateEnabled;

    /** @var string */
    protected $periodsMeasuredIn;

    /** @var int */
    protected $numberOfPeriods;

    /** @var bool */
    protected $proratePriceAllowed;

    /** @var string */
    protected $defaultRenewalMacroId;

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
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @param string $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }

    /**
     * @return string
     */
    public function getProduceLineId()
    {
        return $this->produceLineId;
    }

    /**
     * @param string $produceLineId
     */
    public function setProduceLineId($produceLineId)
    {
        $this->produceLineId = $produceLineId;
    }

    /**
     * @return string
     */
    public function getCostMethod()
    {
        return $this->costMethod;
    }

    /**
     * @param string $costMethod
     */
    public function setCostMethod($costMethod)
    {
        $this->costMethod = $costMethod;
    }

    /**
     * @return string
     */
    public function getExtendedDescription()
    {
        return $this->extendedDescription;
    }

    /**
     * @param string $extendedDescription
     */
    public function setExtendedDescription($extendedDescription)
    {
        $this->extendedDescription = $extendedDescription;
    }

    /**
     * @return string
     */
    public function getSalesDescription()
    {
        return $this->salesDescription;
    }

    /**
     * @param string $salesDescription
     */
    public function setSalesDescription($salesDescription)
    {
        $this->salesDescription = $salesDescription;
    }

    /**
     * @return string
     */
    public function getPurchasingDescription()
    {
        return $this->purchasingDescription;
    }

    /**
     * @param string $purchasingDescription
     */
    public function setPurchasingDescription($purchasingDescription)
    {
        $this->purchasingDescription = $purchasingDescription;
    }

    /**
     * @return string
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

    /**
     * @param string $unitOfMeasure
     */
    public function setUnitOfMeasure($unitOfMeasure)
    {
        $this->unitOfMeasure = $unitOfMeasure;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getExpenseGlAccountNo()
    {
        return $this->expenseGlAccountNo;
    }

    /**
     * @param string $expenseGlAccountNo
     */
    public function setExpenseGlAccountNo($expenseGlAccountNo)
    {
        $this->expenseGlAccountNo = $expenseGlAccountNo;
    }

    /**
     * @return string
     */
    public function getArGlAccountNo()
    {
        return $this->arGlAccountNo;
    }

    /**
     * @param string $arGlAccountNo
     */
    public function setArGlAccountNo($arGlAccountNo)
    {
        $this->arGlAccountNo = $arGlAccountNo;
    }

    /**
     * @return string
     */
    public function getApGlAccountNo()
    {
        return $this->apGlAccountNo;
    }

    /**
     * @param string $apGlAccountNo
     */
    public function setApGlAccountNo($apGlAccountNo)
    {
        $this->apGlAccountNo = $apGlAccountNo;
    }

    /**
     * @return string
     */
    public function getInventoryGlAccountNo()
    {
        return $this->inventoryGlAccountNo;
    }

    /**
     * @param string $inventoryGlAccountNo
     */
    public function setInventoryGlAccountNo($inventoryGlAccountNo)
    {
        $this->inventoryGlAccountNo = $inventoryGlAccountNo;
    }

    /**
     * @return float|int|string
     */
    public function getShippingWeight()
    {
        return $this->shippingWeight;
    }

    /**
     * @param float|int|string $shippingWeight
     */
    public function setShippingWeight($shippingWeight)
    {
        $this->shippingWeight = $shippingWeight;
    }

    /**
     * @return string
     */
    public function getItemGlGroupName()
    {
        return $this->itemGlGroupName;
    }

    /**
     * @param string $itemGlGroupName
     */
    public function setItemGlGroupName($itemGlGroupName)
    {
        $this->itemGlGroupName = $itemGlGroupName;
    }

    /**
     * @return float|string
     */
    public function getStandardCost()
    {
        return $this->standardCost;
    }

    /**
     * @param float|string $standardCost
     */
    public function setStandardCost($standardCost)
    {
        $this->standardCost = $standardCost;
    }

    /**
     * @return string
     */
    public function getCogsGlAccountNo()
    {
        return $this->cogsGlAccountNo;
    }

    /**
     * @param string $cogsGlAccountNo
     */
    public function setCogsGlAccountNo($cogsGlAccountNo)
    {
        $this->cogsGlAccountNo = $cogsGlAccountNo;
    }

    /**
     * @return float|string
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @param float|string $basePrice
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return string
     */
    public function getRevenueGlAccountNo()
    {
        return $this->revenueGlAccountNo;
    }

    /**
     * @param string $revenueGlAccountNo
     */
    public function setRevenueGlAccountNo($revenueGlAccountNo)
    {
        $this->revenueGlAccountNo = $revenueGlAccountNo;
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
    public function getItemTaxGroupName()
    {
        return $this->itemTaxGroupName;
    }

    /**
     * @param string $itemTaxGroupName
     */
    public function setItemTaxGroupName($itemTaxGroupName)
    {
        $this->itemTaxGroupName = $itemTaxGroupName;
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
     * @return string
     */
    public function getDefaultRevRecTemplateId()
    {
        return $this->defaultRevRecTemplateId;
    }

    /**
     * @param string $defaultRevRecTemplateId
     */
    public function setDefaultRevRecTemplateId($defaultRevRecTemplateId)
    {
        $this->defaultRevRecTemplateId = $defaultRevRecTemplateId;
    }

    /**
     * @return string
     */
    public function getVsoeCategory()
    {
        return $this->vsoeCategory;
    }

    /**
     * @param string $vsoeCategory
     */
    public function setVsoeCategory($vsoeCategory)
    {
        $this->vsoeCategory = $vsoeCategory;
    }

    /**
     * @return string
     */
    public function getVsoeDefaultDeliveryStatus()
    {
        return $this->vsoeDefaultDeliveryStatus;
    }

    /**
     * @param string $vsoeDefaultDeliveryStatus
     */
    public function setVsoeDefaultDeliveryStatus($vsoeDefaultDeliveryStatus)
    {
        $this->vsoeDefaultDeliveryStatus = $vsoeDefaultDeliveryStatus;
    }

    /**
     * @return string
     */
    public function getVsoeDefaultDeferralStatus()
    {
        return $this->vsoeDefaultDeferralStatus;
    }

    /**
     * @param string $vsoeDefaultDeferralStatus
     */
    public function setVsoeDefaultDeferralStatus($vsoeDefaultDeferralStatus)
    {
        $this->vsoeDefaultDeferralStatus = $vsoeDefaultDeferralStatus;
    }

    /**
     * @return string
     */
    public function getKitRevenuePosting()
    {
        return $this->kitRevenuePosting;
    }

    /**
     * @param string $kitRevenuePosting
     */
    public function setKitRevenuePosting($kitRevenuePosting)
    {
        $this->kitRevenuePosting = $kitRevenuePosting;
    }

    /**
     * @return string
     */
    public function getKitPrintFormat()
    {
        return $this->kitPrintFormat;
    }

    /**
     * @param string $kitPrintFormat
     */
    public function setKitPrintFormat($kitPrintFormat)
    {
        $this->kitPrintFormat = $kitPrintFormat;
    }

    /**
     * @return string
     */
    public function getSubstituteItemId()
    {
        return $this->substituteItemId;
    }

    /**
     * @param string $substituteItemId
     */
    public function setSubstituteItemId($substituteItemId)
    {
        $this->substituteItemId = $substituteItemId;
    }

    /**
     * @return bool
     */
    public function isSerialTrackingEnabled()
    {
        return $this->serialTrackingEnabled;
    }

    /**
     * @param bool $serialTrackingEnabled
     */
    public function setSerialTrackingEnabled($serialTrackingEnabled)
    {
        $this->serialTrackingEnabled = $serialTrackingEnabled;
    }

    /**
     * @return string
     */
    public function getSerialNumberMask()
    {
        return $this->serialNumberMask;
    }

    /**
     * @param string $serialNumberMask
     */
    public function setSerialNumberMask($serialNumberMask)
    {
        $this->serialNumberMask = $serialNumberMask;
    }

    /**
     * @return bool
     */
    public function isLotTrackingEnabled()
    {
        return $this->lotTrackingEnabled;
    }

    /**
     * @param bool $lotTrackingEnabled
     */
    public function setLotTrackingEnabled($lotTrackingEnabled)
    {
        $this->lotTrackingEnabled = $lotTrackingEnabled;
    }

    /**
     * @return string
     */
    public function getLotCategory()
    {
        return $this->lotCategory;
    }

    /**
     * @param string $lotCategory
     */
    public function setLotCategory($lotCategory)
    {
        $this->lotCategory = $lotCategory;
    }

    /**
     * @return bool
     */
    public function isBinTrackingEnabled()
    {
        return $this->binTrackingEnabled;
    }

    /**
     * @param bool $binTrackingEnabled
     */
    public function setBinTrackingEnabled($binTrackingEnabled)
    {
        $this->binTrackingEnabled = $binTrackingEnabled;
    }

    /**
     * @return bool
     */
    public function isExpTrackingEnabled()
    {
        return $this->expTrackingEnabled;
    }

    /**
     * @param bool $expTrackingEnabled
     */
    public function setExpTrackingEnabled($expTrackingEnabled)
    {
        $this->expTrackingEnabled = $expTrackingEnabled;
    }

    /**
     * @return string
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * @param string $upc
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;
    }

    /**
     * @return int
     */
    public function getUnitCostPrecisionInventory()
    {
        return $this->unitCostPrecisionInventory;
    }

    /**
     * @param int $unitCostPrecisionInventory
     */
    public function setUnitCostPrecisionInventory($unitCostPrecisionInventory)
    {
        $this->unitCostPrecisionInventory = $unitCostPrecisionInventory;
    }

    /**
     * @return int
     */
    public function getUnitCostPrecisionSales()
    {
        return $this->unitCostPrecisionSales;
    }

    /**
     * @param int $unitCostPrecisionSales
     */
    public function setUnitCostPrecisionSales($unitCostPrecisionSales)
    {
        $this->unitCostPrecisionSales = $unitCostPrecisionSales;
    }

    /**
     * @return int
     */
    public function getUnitCostPrecisionPurchasing()
    {
        return $this->unitCostPrecisionPurchasing;
    }

    /**
     * @param int $unitCostPrecisionPurchasing
     */
    public function setUnitCostPrecisionPurchasing($unitCostPrecisionPurchasing)
    {
        $this->unitCostPrecisionPurchasing = $unitCostPrecisionPurchasing;
    }

    /**
     * @return bool
     */
    public function isItemStartEndDateEnabled()
    {
        return $this->itemStartEndDateEnabled;
    }

    /**
     * @param bool $itemStartEndDateEnabled
     */
    public function setItemStartEndDateEnabled($itemStartEndDateEnabled)
    {
        $this->itemStartEndDateEnabled = $itemStartEndDateEnabled;
    }

    /**
     * @return string
     */
    public function getPeriodsMeasuredIn()
    {
        return $this->periodsMeasuredIn;
    }

    /**
     * @param string $periodsMeasuredIn
     */
    public function setPeriodsMeasuredIn($periodsMeasuredIn)
    {
        $this->periodsMeasuredIn = $periodsMeasuredIn;
    }

    /**
     * @return int
     */
    public function getNumberOfPeriods()
    {
        return $this->numberOfPeriods;
    }

    /**
     * @param int $numberOfPeriods
     */
    public function setNumberOfPeriods($numberOfPeriods)
    {
        $this->numberOfPeriods = $numberOfPeriods;
    }

    /**
     * @return bool
     */
    public function isProratePriceAllowed()
    {
        return $this->proratePriceAllowed;
    }

    /**
     * @param bool $proratePriceAllowed
     */
    public function setProratePriceAllowed($proratePriceAllowed)
    {
        $this->proratePriceAllowed = $proratePriceAllowed;
    }

    /**
     * @return string
     */
    public function getDefaultRenewalMacroId()
    {
        return $this->defaultRenewalMacroId;
    }

    /**
     * @param string $defaultRenewalMacroId
     */
    public function setDefaultRenewalMacroId($defaultRenewalMacroId)
    {
        $this->defaultRenewalMacroId = $defaultRenewalMacroId;
    }
}
