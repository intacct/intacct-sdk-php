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

abstract class AbstractProject extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $projectId;

    /** @var string */
    protected $projectName;

    /** @var string */
    protected $projectCategory;

    /** @var string */
    protected $description;

    /** @var string */
    protected $parentProjectId;

    /** @var bool */
    protected $invoiceWithParent;

    /** @var string */
    protected $projectType;

    /** @var string */
    protected $projectStatus;

    /** @var string */
    protected $customerId;

    /** @var string */
    protected $projectManagerEmployeeId;

    /** @var string */
    protected $externalUserId;

    /** @var string */
    protected $salesContactEmployeeId;

    /** @var string */
    protected $referenceNo;

    /** @var string */
    protected $userRestrictions;

    /** @var bool */
    protected $active;

    /** @var string */
    protected $primaryContactName;

    /** @var string */
    protected $billToContactName;

    /** @var string */
    protected $shipToContactName;

    /** @var string */
    protected $paymentTerms;

    /** @var string */
    protected $billingType;

    /** @var \DateTime */
    protected $beginDate;

    /** @var \DateTime */
    protected $endDate;

    /** @var string */
    protected $departmentId;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $classId;

    /** @var string */
    protected $attachmentsId;

    /** @var bool */
    protected $billableEmployeeExpense;

    /** @var bool */
    protected $billableApPurchasing;

    /** @var float|int|string */
    protected $observedPercentComplete;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $salesOrderNo;

    /** @var string */
    protected $purchaseOrderNo;

    /** @var float|string */
    protected $purchaseOrderAmount;

    /** @var string */
    protected $purchaseQuoteNo;

    /** @var float|string */
    protected $contractAmount;

    /** @var string */
    protected $laborPricingOption;

    /** @var float|string */
    protected $laborPricingDefaultRate;

    /** @var string */
    protected $expensePricingOption;

    /** @var float|string */
    protected $expensePricingDefaultRate;

    /** @var string */
    protected $apPurchasingPricingOption;

    /** @var float|string */
    protected $apPurchasingPricingDefaultRate;

    /** @var float|string */
    protected $budgetedBillingAmount;

    /** @var float|string */
    protected $budgetedCost;

    /** @var float|int|string */
    protected $budgetedDuration;

    /** @var string */
    protected $glBudgetId;

    /** @var string */
    protected $invoiceMessage;

    /** @var string */
    protected $invoiceCurrency;

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
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * @param string $projectName
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * @return string
     */
    public function getProjectCategory()
    {
        return $this->projectCategory;
    }

    /**
     * @param string $projectCategory
     */
    public function setProjectCategory($projectCategory)
    {
        $this->projectCategory = $projectCategory;
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
    public function getParentProjectId()
    {
        return $this->parentProjectId;
    }

    /**
     * @param string $parentProjectId
     */
    public function setParentProjectId($parentProjectId)
    {
        $this->parentProjectId = $parentProjectId;
    }

    /**
     * @return bool
     */
    public function isInvoiceWithParent()
    {
        return $this->invoiceWithParent;
    }

    /**
     * @param bool $invoiceWithParent
     */
    public function setInvoiceWithParent($invoiceWithParent)
    {
        $this->invoiceWithParent = $invoiceWithParent;
    }

    /**
     * @return string
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * @param string $projectType
     */
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;
    }

    /**
     * @return string
     */
    public function getProjectStatus()
    {
        return $this->projectStatus;
    }

    /**
     * @param string $projectStatus
     */
    public function setProjectStatus($projectStatus)
    {
        $this->projectStatus = $projectStatus;
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
    public function getProjectManagerEmployeeId()
    {
        return $this->projectManagerEmployeeId;
    }

    /**
     * @param string $projectManagerEmployeeId
     */
    public function setProjectManagerEmployeeId($projectManagerEmployeeId)
    {
        $this->projectManagerEmployeeId = $projectManagerEmployeeId;
    }

    /**
     * @return string
     */
    public function getExternalUserId()
    {
        return $this->externalUserId;
    }

    /**
     * @param string $externalUserId
     */
    public function setExternalUserId($externalUserId)
    {
        $this->externalUserId = $externalUserId;
    }

    /**
     * @return string
     */
    public function getSalesContactEmployeeId()
    {
        return $this->salesContactEmployeeId;
    }

    /**
     * @param string $salesContactEmployeeId
     */
    public function setSalesContactEmployeeId($salesContactEmployeeId)
    {
        $this->salesContactEmployeeId = $salesContactEmployeeId;
    }

    /**
     * @return string
     */
    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    /**
     * @param string $referenceNo
     */
    public function setReferenceNo($referenceNo)
    {
        $this->referenceNo = $referenceNo;
    }

    /**
     * @return string
     */
    public function getUserRestrictions()
    {
        return $this->userRestrictions;
    }

    /**
     * @param string $userRestrictions
     */
    public function setUserRestrictions($userRestrictions)
    {
        $this->userRestrictions = $userRestrictions;
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
    public function getPrimaryContactName()
    {
        return $this->primaryContactName;
    }

    /**
     * @param string $primaryContactName
     */
    public function setPrimaryContactName($primaryContactName)
    {
        $this->primaryContactName = $primaryContactName;
    }

    /**
     * @return string
     */
    public function getBillToContactName()
    {
        return $this->billToContactName;
    }

    /**
     * @param string $billToContactName
     */
    public function setBillToContactName($billToContactName)
    {
        $this->billToContactName = $billToContactName;
    }

    /**
     * @return string
     */
    public function getShipToContactName()
    {
        return $this->shipToContactName;
    }

    /**
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * @return string
     */
    public function getPaymentTerms()
    {
        return $this->paymentTerms;
    }

    /**
     * @param string $paymentTerms
     */
    public function setPaymentTerms($paymentTerms)
    {
        $this->paymentTerms = $paymentTerms;
    }

    /**
     * @return string
     */
    public function getBillingType()
    {
        return $this->billingType;
    }

    /**
     * @param string $billingType
     */
    public function setBillingType($billingType)
    {
        $this->billingType = $billingType;
    }

    /**
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
     * @return bool
     */
    public function isBillableEmployeeExpense()
    {
        return $this->billableEmployeeExpense;
    }

    /**
     * @param bool $billableEmployeeExpense
     */
    public function setBillableEmployeeExpense($billableEmployeeExpense)
    {
        $this->billableEmployeeExpense = $billableEmployeeExpense;
    }

    /**
     * @return bool
     */
    public function isBillableApPurchasing()
    {
        return $this->billableApPurchasing;
    }

    /**
     * @param bool $billableApPurchasing
     */
    public function setBillableApPurchasing($billableApPurchasing)
    {
        $this->billableApPurchasing = $billableApPurchasing;
    }

    /**
     * @return float|int|string
     */
    public function getObservedPercentComplete()
    {
        return $this->observedPercentComplete;
    }

    /**
     * @param float|int|string $observedPercentComplete
     */
    public function setObservedPercentComplete($observedPercentComplete)
    {
        $this->observedPercentComplete = $observedPercentComplete;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getSalesOrderNo()
    {
        return $this->salesOrderNo;
    }

    /**
     * @param string $salesOrderNo
     */
    public function setSalesOrderNo($salesOrderNo)
    {
        $this->salesOrderNo = $salesOrderNo;
    }

    /**
     * @return string
     */
    public function getPurchaseOrderNo()
    {
        return $this->purchaseOrderNo;
    }

    /**
     * @param string $purchaseOrderNo
     */
    public function setPurchaseOrderNo($purchaseOrderNo)
    {
        $this->purchaseOrderNo = $purchaseOrderNo;
    }

    /**
     * @return float|string
     */
    public function getPurchaseOrderAmount()
    {
        return $this->purchaseOrderAmount;
    }

    /**
     * @param float|string $purchaseOrderAmount
     */
    public function setPurchaseOrderAmount($purchaseOrderAmount)
    {
        $this->purchaseOrderAmount = $purchaseOrderAmount;
    }

    /**
     * @return string
     */
    public function getPurchaseQuoteNo()
    {
        return $this->purchaseQuoteNo;
    }

    /**
     * @param string $purchaseQuoteNo
     */
    public function setPurchaseQuoteNo($purchaseQuoteNo)
    {
        $this->purchaseQuoteNo = $purchaseQuoteNo;
    }

    /**
     * @return float|string
     */
    public function getContractAmount()
    {
        return $this->contractAmount;
    }

    /**
     * @param float|string $contractAmount
     */
    public function setContractAmount($contractAmount)
    {
        $this->contractAmount = $contractAmount;
    }

    /**
     * @return string
     */
    public function getLaborPricingOption()
    {
        return $this->laborPricingOption;
    }

    /**
     * @param string $laborPricingOption
     */
    public function setLaborPricingOption($laborPricingOption)
    {
        $this->laborPricingOption = $laborPricingOption;
    }

    /**
     * @return float|string
     */
    public function getLaborPricingDefaultRate()
    {
        return $this->laborPricingDefaultRate;
    }

    /**
     * @param float|string $laborPricingDefaultRate
     */
    public function setLaborPricingDefaultRate($laborPricingDefaultRate)
    {
        $this->laborPricingDefaultRate = $laborPricingDefaultRate;
    }

    /**
     * @return string
     */
    public function getExpensePricingOption()
    {
        return $this->expensePricingOption;
    }

    /**
     * @param string $expensePricingOption
     */
    public function setExpensePricingOption($expensePricingOption)
    {
        $this->expensePricingOption = $expensePricingOption;
    }

    /**
     * @return float|string
     */
    public function getExpensePricingDefaultRate()
    {
        return $this->expensePricingDefaultRate;
    }

    /**
     * @param float|string $expensePricingDefaultRate
     */
    public function setExpensePricingDefaultRate($expensePricingDefaultRate)
    {
        $this->expensePricingDefaultRate = $expensePricingDefaultRate;
    }

    /**
     * @return string
     */
    public function getApPurchasingPricingOption()
    {
        return $this->apPurchasingPricingOption;
    }

    /**
     * @param string $apPurchasingPricingOption
     */
    public function setApPurchasingPricingOption($apPurchasingPricingOption)
    {
        $this->apPurchasingPricingOption = $apPurchasingPricingOption;
    }

    /**
     * @return float|string
     */
    public function getApPurchasingPricingDefaultRate()
    {
        return $this->apPurchasingPricingDefaultRate;
    }

    /**
     * @param float|string $apPurchasingPricingDefaultRate
     */
    public function setApPurchasingPricingDefaultRate($apPurchasingPricingDefaultRate)
    {
        $this->apPurchasingPricingDefaultRate = $apPurchasingPricingDefaultRate;
    }

    /**
     * @return float|string
     */
    public function getBudgetedBillingAmount()
    {
        return $this->budgetedBillingAmount;
    }

    /**
     * @param float|string $budgetedBillingAmount
     */
    public function setBudgetedBillingAmount($budgetedBillingAmount)
    {
        $this->budgetedBillingAmount = $budgetedBillingAmount;
    }

    /**
     * @return float|string
     */
    public function getBudgetedCost()
    {
        return $this->budgetedCost;
    }

    /**
     * @param float|string $budgetedCost
     */
    public function setBudgetedCost($budgetedCost)
    {
        $this->budgetedCost = $budgetedCost;
    }

    /**
     * @return float|int|string
     */
    public function getBudgetedDuration()
    {
        return $this->budgetedDuration;
    }

    /**
     * @param float|int|string $budgetedDuration
     */
    public function setBudgetedDuration($budgetedDuration)
    {
        $this->budgetedDuration = $budgetedDuration;
    }

    /**
     * @return string
     */
    public function getGlBudgetId()
    {
        return $this->glBudgetId;
    }

    /**
     * @param string $glBudgetId
     */
    public function setGlBudgetId($glBudgetId)
    {
        $this->glBudgetId = $glBudgetId;
    }

    /**
     * @return string
     */
    public function getInvoiceMessage()
    {
        return $this->invoiceMessage;
    }

    /**
     * @param string $invoiceMessage
     */
    public function setInvoiceMessage($invoiceMessage)
    {
        $this->invoiceMessage = $invoiceMessage;
    }

    /**
     * @return string
     */
    public function getInvoiceCurrency()
    {
        return $this->invoiceCurrency;
    }

    /**
     * @param string $invoiceCurrency
     */
    public function setInvoiceCurrency($invoiceCurrency)
    {
        $this->invoiceCurrency = $invoiceCurrency;
    }
}
