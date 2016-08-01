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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Fields\Date;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractGlEntry extends AbstractFunction
{

    /** @var string */
    const CUSTOM_ALLOCATION_ID = 'Custom';

    use CustomFieldsTrait;

    /** @var string */
    protected $documentNumber;

    /** @var string */
    protected $glAccountNumber;

    /** @var string|float */
    protected $transactionAmount;

    /** @var string */
    protected $transactionCurrency;

    /** @var Date */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var string */
    protected $statAccountNumber;

    /** @var string|float|int */
    protected $amount;

    /** @var string */
    protected $allocationId;

    /** @var string */
    protected $memo;

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

    /** @var array */
    protected $customAllocationSplits;
}
