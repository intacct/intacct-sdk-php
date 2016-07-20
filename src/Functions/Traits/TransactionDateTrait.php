<?php
/**
 *
 * *
 *  * Copyright 2016 Intacct Corporation.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  * use this file except in compliance with the License. You may obtain a copy
 *  * of the License at
 *  *
 *  * http://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * or in the "LICENSE" file accompanying this file. This file is distributed on
 *  * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 *  * express or implied. See the License for the specific language governing
 *  * permissions and limitations under the License.
 *
 *
 */

namespace Intacct\Functions\Traits;

use Intacct\Fields\Date;

trait TransactionDateTrait
{

    /**
     *
     * @var Date
     */
    private $transactionDate;

    /**
     * @return Date
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param string|Date $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        if ($transactionDate instanceof Date) {
            $this->transactionDate = $transactionDate;
        } else {
            $this->transactionDate = new Date($transactionDate);
        }
    }
}