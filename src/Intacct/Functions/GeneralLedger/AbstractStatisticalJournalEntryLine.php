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

namespace Intacct\Functions\GeneralLedger;

abstract class AbstractStatisticalJournalEntryLine extends AbstractGlEntry
{

    /** @var string */
    protected $statAccountNumber;

    /** @var float|int */
    protected $amount;

    /**
     * @return string
     */
    public function getStatAccountNumber()
    {
        return $this->statAccountNumber;
    }

    /**
     * @param string $statAccountNumber
     */
    public function setStatAccountNumber($statAccountNumber)
    {
        $this->statAccountNumber = $statAccountNumber;
    }

    /**
     * @return float|int|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|int|string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
