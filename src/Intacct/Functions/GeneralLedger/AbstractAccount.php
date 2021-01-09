<?php

/*
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

namespace Intacct\Functions\GeneralLedger;

abstract class AbstractAccount extends AbstractGlAccount
{

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

    /**
     * @return string
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param string $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * @return string
     */
    public function getNormalBalance()
    {
        return $this->normalBalance;
    }

    /**
     * @param string $normalBalance
     */
    public function setNormalBalance($normalBalance)
    {
        $this->normalBalance = $normalBalance;
    }

    /**
     * @return string
     */
    public function getClosingType()
    {
        return $this->closingType;
    }

    /**
     * @param string $closingType
     */
    public function setClosingType($closingType)
    {
        $this->closingType = $closingType;
    }

    /**
     * @return string
     */
    public function getCloseIntoGlAccountNo()
    {
        return $this->closeIntoGlAccountNo;
    }

    /**
     * @param string $closeIntoGlAccountNo
     */
    public function setCloseIntoGlAccountNo($closeIntoGlAccountNo)
    {
        $this->closeIntoGlAccountNo = $closeIntoGlAccountNo;
    }

    /**
     * @return string
     */
    public function getGlAccountAlternative()
    {
        return $this->glAccountAlternative;
    }

    /**
     * @param string $glAccountAlternative
     */
    public function setGlAccountAlternative($glAccountAlternative)
    {
        $this->glAccountAlternative = $glAccountAlternative;
    }

    /**
     * @return string
     */
    public function getTaxReturnCode()
    {
        return $this->taxReturnCode;
    }

    /**
     * @param string $taxReturnCode
     */
    public function setTaxReturnCode($taxReturnCode)
    {
        $this->taxReturnCode = $taxReturnCode;
    }

    /**
     * @return string
     */
    public function getM3ReturnCode()
    {
        return $this->m3ReturnCode;
    }

    /**
     * @param string $m3ReturnCode
     */
    public function setM3ReturnCode($m3ReturnCode)
    {
        $this->m3ReturnCode = $m3ReturnCode;
    }

    /**
     * @return bool
     */
    public function isTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param bool $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    }
}
