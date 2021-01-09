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

class ApPaymentDetailBuilder
{
    /** @var array */
    private $_detailList = [];

    public function __construct()
    {
    }

    public function addApPaymentDetailBill(ApPaymentDetailBillInfo $info): ApPaymentDetailBuilder
    {
        $this->_detailList[] = new ApPaymentDetailBill($info);
        return $this;
    }

    public function addApPaymentDetailCreditMemo(ApPaymentDetailInfo $info): ApPaymentDetailBuilder
    {
        $this->_detailList[] = new ApPaymentDetailCreditMemo($info);
        return $this;
    }

    public function getApPaymentDetailList(): array
    {
        return $this->_detailList;
    }
}
