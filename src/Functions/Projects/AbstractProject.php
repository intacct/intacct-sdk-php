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

    /** @var Date */
    protected $beginDate;

    /** @var Date */
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
}
