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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractExpenseType extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $expenseType;

    /** @var string */
    protected $itemId;

    /** @var string */
    protected $description;

    /** @var string */
    protected $glAccountNo;

    /** @var string */
    protected $offsetGlAccountNo;

    /** @var bool */
    protected $active;

    /**
     * @return string
     */
    public function getExpenseType()
    {
        return $this->expenseType;
    }

    /**
     * @param string $expenseType
     */
    public function setExpenseType($expenseType)
    {
        $this->expenseType = $expenseType;
    }

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
    public function getGlAccountNo()
    {
        return $this->glAccountNo;
    }

    /**
     * @param string $glAccountNo
     */
    public function setGlAccountNo($glAccountNo)
    {
        $this->glAccountNo = $glAccountNo;
    }

    /**
     * @return string
     */
    public function getOffsetGlAccountNo()
    {
        return $this->offsetGlAccountNo;
    }

    /**
     * @param string $offsetGlAccountNo
     */
    public function setOffsetGlAccountNo($offsetGlAccountNo)
    {
        $this->offsetGlAccountNo = $offsetGlAccountNo;
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
}
