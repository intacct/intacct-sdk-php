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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractDepartment extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $departmentId;

    /** @var string */
    protected $departmentName;

    /** @var string */
    protected $parentDepartmentId;

    /** @var string */
    protected $managerEmployeeId;

    /** @var string */
    protected $departmentTitle;

    /** @var bool */
    protected $active;

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
    public function getDepartmentName()
    {
        return $this->departmentName;
    }

    /**
     * @param string $departmentName
     */
    public function setDepartmentName($departmentName)
    {
        $this->departmentName = $departmentName;
    }

    /**
     * @return string
     */
    public function getParentDepartmentId()
    {
        return $this->parentDepartmentId;
    }

    /**
     * @param string $parentDepartmentId
     */
    public function setParentDepartmentId($parentDepartmentId)
    {
        $this->parentDepartmentId = $parentDepartmentId;
    }

    /**
     * @return string
     */
    public function getManagerEmployeeId()
    {
        return $this->managerEmployeeId;
    }

    /**
     * @param string $managerEmployeeId
     */
    public function setManagerEmployeeId($managerEmployeeId)
    {
        $this->managerEmployeeId = $managerEmployeeId;
    }

    /**
     * @return string
     */
    public function getDepartmentTitle()
    {
        return $this->departmentTitle;
    }

    /**
     * @param string $departmentTitle
     */
    public function setDepartmentTitle($departmentTitle)
    {
        $this->departmentTitle = $departmentTitle;
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
}
