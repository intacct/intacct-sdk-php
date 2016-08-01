<?php

/*
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

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractGlAccount extends AbstractFunction
{
    
    use CustomFieldsTrait;
    
    /** @var string */
    protected $accountNo;
    
    /** @var string */
    protected $title;
    
    /** @var string */
    protected $systemCategory;
    
    /** @var string */
    protected $accountType;
    
    /** @var string */
    protected $normalBalance;
    
    /** @var string */
    protected $closingType;
    
    /** @var string */
    protected $closeIntoGlAccountNo;
    
    /** @var string */
    protected $glAccountAlternative;
    
    /** @var string */
    protected $taxReturnCode;
    
    /** @var string */
    protected $m3ReturnCode;
    
    /** @var bool */
    protected $taxable;
    
    /** @var bool */
    protected $active;

    /** @var bool */
    protected $requireDepartment;
    
    /** @var bool */
    protected $requireLocation;
    
    /** @var bool */
    protected $requireProject;
    
    /** @var bool */
    protected $requireCustomer;
    
    /** @var bool */
    protected $requireVendor;
    
    /** @var bool */
    protected $requireEmployee;
    
    /** @var bool */
    protected $requireItem;
    
    /** @var bool */
    protected $requireClass;
    
    /** @var bool */
    protected $requireContract;
    
    /** @var bool */
    protected $requireWarehouse;
    
    /** @var string */
    protected $reportType;
}
