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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Xml\XMLWriter;

abstract class AbstractApPaymentDetailCredit
{
    public const DEBIT_MEMO = 'debit memo';

    public const NEGATIVE_BILL = 'negative bill';

    public const ADVANCE = 'advance';

    /** @var int */
    public $recordNo;

    /** @var int */
    public $lineRecordNo;

    /** @var float|int|string */
    public $transactionAmount;

    /**
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter $xml): void
    {
        $xml->writeElement($this->getKeyType(), $this->recordNo, true);
        if (isset($this->lineRecordNo)) {
            $xml->writeElement($this->getEntryKeyType(), $this->lineRecordNo);
        }
        if (isset($this->transactionAmount)) {
            $xml->writeElement($this->getTransactionType(), $this->transactionAmount);
        }
    }

    /** @return string */
    abstract protected function getKeyType(): string;

    /** @return string */
    abstract protected function getEntryKeyType(): string;

    /** @return string */
    abstract protected function getTransactionType(): string;
}