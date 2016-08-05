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

namespace Intacct\Functions\Projects;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class UpdateProject extends AbstractProject
{

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
     * @return boolean
     */
    public function isInvoiceWithParent()
    {
        return $this->invoiceWithParent;
    }

    /**
     * @param boolean $invoiceWithParent
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
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
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
     * @return Date
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param Date $beginDate
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return Date
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param Date $endDate
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
     * @return boolean
     */
    public function isBillableEmployeeExpense()
    {
        return $this->billableEmployeeExpense;
    }

    /**
     * @param boolean $billableEmployeeExpense
     */
    public function setBillableEmployeeExpense($billableEmployeeExpense)
    {
        $this->billableEmployeeExpense = $billableEmployeeExpense;
    }

    /**
     * @return boolean
     */
    public function isBillableApPurchasing()
    {
        return $this->billableApPurchasing;
    }

    /**
     * @param boolean $billableApPurchasing
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

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'project_id' => null,
            'project_name' => null,
            'project_category' => null,
            'description' => null,
            'parent_project_id' => null,
            'invoice_with_parent' => null,
            'project_type' => null,
            'project_status' => null,
            'customer_id' => null,
            'project_manager_employee_id' => null,
            'external_user_id' => null,
            'sales_contact_employee_id' => null,
            'reference_no' => null,
            'user_restrictions' => null,
            'active' => null,
            'primary_contact_name' => null,
            'bill_to_contact_name' => null,
            'ship_to_contact_name' => null,
            'payment_terms' => null,
            'billing_type' => null,
            'begin_date' => null,
            'end_date' => null,
            'department_id' => null,
            'location_id' => null,
            'class_id' => null,
            'attachments_id' => null,
            'billable_employee_expenses' => null,
            'billable_ap_purchasing' => null,
            'observed_percent_complete' => null,
            'currency' => null,
            'sales_order_no' => null,
            'purchase_order_no' => null,
            'purchase_order_amount' => null,
            'purchase_quote_no' => null,
            'contract_amount' => null,
            'labor_pricing_option' => null,
            'labor_pricing_default_rate' => null,
            'expense_pricing_option' => null,
            'expense_pricing_default_rate' => null,
            'ap_purchasing_pricing_option' => null,
            'ap_purchasing_pricing_default_rate' => null,
            'budgeted_billing_amount' => null,
            'budgeted_cost' => null,
            'budgeted_duration' => null,
            'gl_budget_id' => null,
            'invoice_message' => null,
            'invoice_currency' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setProjectId($config['project_id']);
        $this->setProjectName($config['project_name']);
        $this->setProjectCategory($config['project_category']);
        $this->setDescription($config['description']);
        $this->setParentProjectId($config['parent_project_id']);
        $this->setInvoiceWithParent($config['invoice_with_parent']);
        $this->setProjectType($config['project_type']);
        $this->setProjectStatus($config['project_status']);
        $this->setCustomerId($config['customer_id']);
        $this->setProjectManagerEmployeeId($config['project_manager_employee_id']);
        $this->setExternalUserId($config['external_user_id']);
        $this->setSalesContactEmployeeId($config['sales_contact_employee_id']);
        $this->setReferenceNo($config['reference_no']);
        $this->setUserRestrictions($config['user_restrictions']);
        $this->setActive($config['active']);
        $this->setPrimaryContactName($config['primary_contact_name']);
        $this->setBillToContactName($config['bill_to_contact_name']);
        $this->setShipToContactName($config['ship_to_contact_name']);
        $this->setPaymentTerms($config['payment_terms']);
        $this->setBillingType($config['billing_type']);
        $this->setBeginDate($config['begin_date']);
        $this->setEndDate($config['end_date']);
        $this->setDepartmentId($config['department_id']);
        $this->setLocationId($config['location_id']);
        $this->setClassId($config['class_id']);
        $this->setAttachmentsId($config['attachments_id']);
        $this->setBillableEmployeeExpense($config['billable_employee_expenses']);
        $this->setBillableApPurchasing($config['billable_ap_purchasing']);
        $this->setObservedPercentComplete($config['observed_percent_complete']);
        $this->setCurrency($config['currency']);
        $this->setSalesOrderNo($config['sales_order_no']);
        $this->setPurchaseOrderNo($config['purchase_order_no']);
        $this->setPurchaseOrderAmount($config['purchase_order_amount']);
        $this->setPurchaseQuoteNo($config['purchase_quote_no']);
        $this->setContractAmount($config['contract_amount']);
        $this->setLaborPricingOption($config['labor_pricing_option']);
        $this->setLaborPricingDefaultRate($config['labor_pricing_default_rate']);
        $this->setExpensePricingOption($config['expense_pricing_option']);
        $this->setExpensePricingDefaultRate($config['expense_pricing_default_rate']);
        $this->setApPurchasingPricingOption($config['ap_purchasing_pricing_option']);
        $this->setApPurchasingPricingDefaultRate($config['ap_purchasing_pricing_default_rate']);
        $this->setBudgetedBillingAmount($config['budgeted_billing_amount']);
        $this->setBudgetedCost($config['budgeted_cost']);
        $this->setBudgetedDuration($config['budgeted_duration']);
        $this->setGlBudgetId($config['gl_budget_id']);
        $this->setInvoiceMessage($config['invoice_message']);
        $this->setInvoiceCurrency($config['invoice_currency']);

        $this->setCustomFields($config['custom_fields']);
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('update');
        $xml->startElement('PROJECT');

        if (!$this->getProjectId()) {
            throw new InvalidArgumentException('Project ID is required for update');
        }
        $xml->writeElement('PROJECTID', $this->getProjectId(), true);

        $xml->writeElement('NAME', $this->getProjectName());
        $xml->writeElement('PROJECTCATEGORY', $this->getProjectCategory());
        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('PARENTID', $this->getParentProjectId());
        $xml->writeElement('INVOICEWITHPARENT', $this->isInvoiceWithParent());
        $xml->writeElement('PROJECTTYPE', $this->getProjectType());
        $xml->writeElement('PROJECTSTATUS', $this->getProjectStatus());
        $xml->writeElement('CUSTOMERID', $this->getCustomerId());
        $xml->writeElement('MANAGERID', $this->getProjectManagerEmployeeId());
        $xml->writeElement('CUSTUSERID', $this->getExternalUserId());
        $xml->writeElement('SALESCONTACTID', $this->getSalesContactEmployeeId());
        $xml->writeElement('DOCNUMBER', $this->getReferenceNo());
        $xml->writeElement('USERRESTRICTIONS', $this->getUserRestrictions());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        if ($this->getPrimaryContactName() !== null) {
            $xml->startElement('CONTACTINFO');
            $xml->writeElement('CONTACTNAME', $this->getPrimaryContactName(), true);
            $xml->endElement();
        }

        if ($this->getBillToContactName() !== null) {
            $xml->startElement('BILLTO');
            $xml->writeElement('CONTACTNAME', $this->getBillToContactName(), true);
            $xml->endElement();
        }

        if ($this->getShipToContactName() !== null) {
            $xml->startElement('SHIPTO');
            $xml->writeElement('CONTACTNAME', $this->getShipToContactName(), true);
            $xml->endElement();
        }

        $xml->writeElement('TERMNAME', $this->getPaymentTerms());
        $xml->writeElement('BILLINGTYPE', $this->getBillingType());
        $xml->writeElement('BEGINDATE', $this->getBeginDate());
        $xml->writeElement('ENDDATE', $this->getEndDate());
        $xml->writeElement('DEPARTMENTID', $this->getDepartmentId());
        $xml->writeElement('LOCATIONID', $this->getLocationId());
        $xml->writeElement('CLASSID', $this->getClassId());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('BILLABLEEXPDEFAULT', $this->isBillableEmployeeExpense());
        $xml->writeElement('BILLABLEAPPODEFAULT', $this->isBillableApPurchasing());
        $xml->writeElement('OBSPERCENTCOMPLETE', $this->getObservedPercentComplete());
        $xml->writeElement('CURRENCY', $this->getCurrency());
        $xml->writeElement('SONUMBER', $this->getSalesOrderNo());
        $xml->writeElement('PONUMBER', $this->getPurchaseOrderNo());
        $xml->writeElement('POAMOUNT', $this->getPurchaseOrderAmount());
        $xml->writeElement('PQNUMBER', $this->getPurchaseQuoteNo());
        $xml->writeElement('CONTRACTAMOUNT', $this->getContractAmount());
        $xml->writeElement('BILLINGPRICING', $this->getLaborPricingOption());
        $xml->writeElement('BILLINGRATE', $this->getLaborPricingDefaultRate());
        $xml->writeElement('EXPENSEPRICING', $this->getExpensePricingOption());
        $xml->writeElement('EXPENSERATE', $this->getExpensePricingDefaultRate());
        $xml->writeElement('POAPPRICING', $this->getApPurchasingPricingOption());
        $xml->writeElement('POAPRATE', $this->getApPurchasingPricingDefaultRate());
        $xml->writeElement('BUDGETAMOUNT', $this->getBudgetedBillingAmount());
        $xml->writeElement('BUDGETEDCOST', $this->getBudgetedCost());
        $xml->writeElement('BUDGETQTY', $this->getBudgetedDuration());
        $xml->writeElement('BUDGETID', $this->getGlBudgetId());
        $xml->writeElement('INVOICEMESSAGE', $this->getInvoiceMessage());
        $xml->writeElement('INVOICECURRENCY', $this->getInvoiceCurrency());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //PROJECT
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
