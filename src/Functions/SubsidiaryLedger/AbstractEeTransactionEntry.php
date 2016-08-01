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

use Intacct\Fields\Date;
use Intacct\Functions\Traits\CustomFieldsTrait;

class AbstractEeTransactionEntry
{

    use CustomFieldsTrait;

    /** @var string */
    protected $expenseType;

    /** @var string */
    protected $glAccountNumber;

    /** @var string|float */
    protected $reimbursementAmount;

    /** @var string */
    protected $paymentTypeName;

    /** @var bool */
    protected $form1099;

    /** @var string */
    protected $paidTo;

    /** @var string */
    protected $paidFor;

    /** @var string */
    protected $memo;

    /** @var Date */
    protected $expenseDate;

    /** @var int|float|string */
    protected $quantity;

    /** @var int|float|string */
    protected $unitRate;

    /** @var string */
    protected $transactionCurrency;

    /** @var float|string */
    protected $transactionAmount;

    /** @var Date */
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
}
