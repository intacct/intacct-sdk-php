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

abstract class AbstractTransactionEntry
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

    /** @var bool */
    protected $form1099;

    /** @var string */
    protected $key;

    /** @var string|float */
    protected $totalPaid;

    /** @var string|float */
    protected $totalDue;

    /** @var bool */
    protected $billable;

    /** @var string */
    protected $revRecTemplateId;

    /** @var string */
    protected $deferredRevGlAccountNo;

    /** @var Date */
    protected $revRecStartDate;

    /** @var Date */
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
}
