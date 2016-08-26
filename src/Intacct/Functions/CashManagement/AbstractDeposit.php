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

namespace Intacct\Functions\CashManagement;

use Intacct\FieldTypes\DateType;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractDeposit extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $bankAccountId;

    /** @var DateType */
    protected $depositDate;

    /** @var string */
    protected $depositSlipId;

    /** @var string */
    protected $description;

    /** @var string */
    protected $attachmentsId;

    /** @var int[] */
    protected $transactionsKeysToDeposit;

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
     * @return DateType
     */
    public function getDepositDate()
    {
        return $this->depositDate;
    }

    /**
     * @param DateType $depositDate
     */
    public function setDepositDate($depositDate)
    {
        $this->depositDate = $depositDate;
    }

    /**
     * @return string
     */
    public function getDepositSlipId()
    {
        return $this->depositSlipId;
    }

    /**
     * @param string $depositSlipId
     */
    public function setDepositSlipId($depositSlipId)
    {
        $this->depositSlipId = $depositSlipId;
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
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
    }

    /**
     * @return int[]
     */
    public function getTransactionKeysToDeposit()
    {
        return $this->transactionsKeysToDeposit;
    }

    /**
     * @param int[] $transactionKeysToDeposit
     */
    public function setTransactionKeysToDeposit($transactionKeysToDeposit)
    {
        $this->transactionsKeysToDeposit = $transactionKeysToDeposit;
    }
}
