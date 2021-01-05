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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Functions\AbstractFunction;

abstract class AbstractArAccountLabel extends AbstractFunction
{

    /** @var string */
    protected $accountLabel;

    /** @var string */
    protected $description;

    /** @var string */
    protected $glAccountNo;

    /** @var string */
    protected $offsetGlAccountNo;

    /** @var bool */
    protected $active;

    /**
     * Get account label
     *
     * @return string
     */
    public function getAccountLabel()
    {
        return $this->accountLabel;
    }

    /**
     * Set account label
     *
     * @param string $accountLabel
     */
    public function setAccountLabel($accountLabel)
    {
        $this->accountLabel = $accountLabel;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get GL account number
     *
     * @return string
     */
    public function getGlAccountNo()
    {
        return $this->glAccountNo;
    }

    /**
     * Set GL account number
     *
     * @param string $glAccountNo
     */
    public function setGlAccountNo($glAccountNo)
    {
        $this->glAccountNo = $glAccountNo;
    }

    /**
     * Get offset GL account number
     *
     * @return string
     */
    public function getOffsetGlAccountNo()
    {
        return $this->offsetGlAccountNo;
    }

    /**
     * Set offset GL account number
     *
     * @param string $offsetGlAccountNo
     */
    public function setOffsetGlAccountNo($offsetGlAccountNo)
    {
        $this->offsetGlAccountNo = $offsetGlAccountNo;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}
