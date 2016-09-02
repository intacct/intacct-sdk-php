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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\FieldTypes\DateType;
use Intacct\Functions\AbstractFunction;

abstract class AbstractArPaymentSummary extends AbstractFunction
{

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $title;

    /** @var DateType */
    protected $glPostingDate;

    /** @var string */
    protected $bankAccountId;

    /** @var string */
    protected $undepositedFundsGlAccountNo;

    // TODO: Allow setting AbstractArPayment

    /**
     * @return int|string
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * @param int|string $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
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
     * @return DateType
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * @param DateType $glPostingDate
     */
    public function setGlPostingDate($glPostingDate)
    {
        $this->glPostingDate = $glPostingDate;
    }

    /**
     * @return string
     */
    public function getBankAccountId()
    {
        return $this->bankAccountId;
    }

    /**
     * @param string $bankAccountId
     */
    public function setBankAccountId($bankAccountId)
    {
        $this->bankAccountId = $bankAccountId;
    }

    /**
     * @return string
     */
    public function getUndepositedFundsGlAccountNo()
    {
        return $this->undepositedFundsGlAccountNo;
    }

    /**
     * @param string $undepositedFundsGlAccountNo
     */
    public function setUndepositedFundsGlAccountNo($undepositedFundsGlAccountNo)
    {
        $this->undepositedFundsGlAccountNo = $undepositedFundsGlAccountNo;
    }
}
