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

class ApPaymentDetailBill implements IApPaymentDetail
{
    /** @var ApPaymentDetailBillInfo */
    private $info;

    public function __construct(ApPaymentDetailBillInfo $info)
    {
        $this->info = $info;
    }
    public function writeXml(XMLWriter &$xml): void
    {
        $xml->startElement("APPYMTDETAIL");

        $xml->writeElement("RECORDKEY", $this->info->recordNo, true);
        if (isset($this->info->lineRecordNo)) {
            $xml->writeElement("ENTRYKEY", $this->info->lineRecordNo);
        }

        if (isset($this->info->applyToDiscountDate)) {
            $xml->writeElementDate("DISCOUNTDATE", $this->info->applyToDiscountDate);
        } elseif (isset($this->info->discountToApply)) {
            $xml->writeElement("DISCOUNTTOAPPLY", $this->info->discountToApply);
        }

        if (isset($this->info->detailTransaction)) {
            $this->info->detailTransaction->writeXml($xml);
        } elseif (isset($this->info->creditToApply)) {
            $xml->writeElement("CREDITTOAPPLY", $this->info->creditToApply);
        }

        if (isset($this->info->paymentAmount)) {
            $xml->writeElement("TRX_PAYMENTAMOUNT", $this->info->paymentAmount);
        }

        $xml->endElement(); // APPYMTDETAIL
    }
}
