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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Apply an existing accounts receivable payment record
 */
class ArPaymentApply extends AbstractArPayment
{
    /**
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('apply_arpayment');

        if (!$this->getRecordNo()) {
            throw new InvalidArgumentException('Record No is required for apply');
        }
        $xml->writeElement('arpaymentkey', $this->getRecordNo(), true);

        if (!$this->getReceivedDate()) {
            throw new InvalidArgumentException('Received Date is required for apply');
        }
        $xml->startElement('paymentdate');
        $xml->writeDateSplitElements($this->getReceivedDate(), true);
        $xml->endElement(); //paymentdate

        $xml->writeElement('batchkey', $this->getSummaryRecordNo());
        $xml->writeElement('overpaylocid', $this->getOverpaymentLocationId());
        $xml->writeElement('overpaydeptid', $this->getOverpaymentDepartmentId());

        if (count($this->getApplyToTransactions()) > 0) {
            $xml->startElement('arpaymentitems');
            foreach ($this->getApplyToTransactions() as $applyToTransaction) {
                $applyToTransaction->writeXml($xml);
            }
            $xml->endElement(); //arpaymentitems
        }

        $xml->endElement(); //apply_arpayment

        $xml->endElement(); //function
    }
}
