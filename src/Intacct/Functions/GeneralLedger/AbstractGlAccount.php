<?php

/*
 * Copyright 2017 Sage Intacct, Inc.
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

    /**
     * @return string
     */
    public function getAccountNo()
    {
        return $this->accountNo;
    }

    /**
     * @param string $accountNo
     */
    public function setAccountNo($accountNo)
    {
        $this->accountNo = $accountNo;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSystemCategory()
    {
        return $this->systemCategory;
    }

    /**
     * @param string $systemCategory
     */
    public function setSystemCategory($systemCategory)
    {
        $this->systemCategory = $systemCategory;
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
     * @return boolean
     */
    public function isRequireDepartment()
    {
        return $this->requireDepartment;
    }

    /**
     * @param boolean $requireDepartment
     */
    public function setRequireDepartment($requireDepartment)
    {
        $this->requireDepartment = $requireDepartment;
    }

    /**
     * @return boolean
     */
    public function isRequireLocation()
    {
        return $this->requireLocation;
    }

    /**
     * @param boolean $requireLocation
     */
    public function setRequireLocation($requireLocation)
    {
        $this->requireLocation = $requireLocation;
    }

    /**
     * @return boolean
     */
    public function isRequireProject()
    {
        return $this->requireProject;
    }

    /**
     * @param boolean $requireProject
     */
    public function setRequireProject($requireProject)
    {
        $this->requireProject = $requireProject;
    }

    /**
     * @return boolean
     */
    public function isRequireCustomer()
    {
        return $this->requireCustomer;
    }

    /**
     * @param boolean $requireCustomer
     */
    public function setRequireCustomer($requireCustomer)
    {
        $this->requireCustomer = $requireCustomer;
    }

    /**
     * @return boolean
     */
    public function isRequireVendor()
    {
        return $this->requireVendor;
    }

    /**
     * @param boolean $requireVendor
     */
    public function setRequireVendor($requireVendor)
    {
        $this->requireVendor = $requireVendor;
    }

    /**
     * @return boolean
     */
    public function isRequireEmployee()
    {
        return $this->requireEmployee;
    }

    /**
     * @param boolean $requireEmployee
     */
    public function setRequireEmployee($requireEmployee)
    {
        $this->requireEmployee = $requireEmployee;
    }

    /**
     * @return boolean
     */
    public function isRequireItem()
    {
        return $this->requireItem;
    }

    /**
     * @param boolean $requireItem
     */
    public function setRequireItem($requireItem)
    {
        $this->requireItem = $requireItem;
    }

    /**
     * @return boolean
     */
    public function isRequireClass()
    {
        return $this->requireClass;
    }

    /**
     * @param boolean $requireClass
     */
    public function setRequireClass($requireClass)
    {
        $this->requireClass = $requireClass;
    }

    /**
     * @return boolean
     */
    public function isRequireContract()
    {
        return $this->requireContract;
    }

    /**
     * @param boolean $requireContract
     */
    public function setRequireContract($requireContract)
    {
        $this->requireContract = $requireContract;
    }

    /**
     * @return boolean
     */
    public function isRequireWarehouse()
    {
        return $this->requireWarehouse;
    }

    /**
     * @param boolean $requireWarehouse
     */
    public function setRequireWarehouse($requireWarehouse)
    {
        $this->requireWarehouse = $requireWarehouse;
    }
}
