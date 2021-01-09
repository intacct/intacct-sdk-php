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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new employee expense reimbursement request record
 */
class ReimbursementRequestCreate extends AbstractReimbursementRequest
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_reimbursementrequest');

        if (!$this->getBankAccountId()) {
            throw new InvalidArgumentException('Bank Account ID is required for create reimbursement request');
        }
        $xml->writeElement('bankaccountid', $this->getBankAccountId(), true);

        if (!$this->getEmployeeId()) {
            throw new InvalidArgumentException('Employee ID is required for create reimbursement request');
        }
        $xml->writeElement('employeeid', $this->getEmployeeId(), true);

        $xml->writeElement('memo', $this->getMemo());

        if (!$this->getPaymentMethod()) {
            throw new InvalidArgumentException('Payment Method is required for create reimbursement request');
        }
        $xml->writeElement('paymentmethod', $this->getPaymentMethod(), true);

        if (!$this->getPaymentDate()) {
            throw new InvalidArgumentException('Payment Date is required for create reimbursement request');
        }
        $xml->startElement('paymentdate');
        $xml->writeDateSplitElements($this->getPaymentDate(), true);
        $xml->endElement(); //paymentdate

        $xml->writeElement('paymentoption', $this->getMergeOption());

        if (count($this->getApplyToTransactions()) > 0) {
            $xml->startElement('eppaymentrequestitems');
            foreach ($this->getApplyToTransactions() as $applyToTransaction) {
                $applyToTransaction->writeXml($xml);
            }
            $xml->endElement(); //eppaymentrequestitems
        } else {
            throw new InvalidArgumentException(
                'EE Reimbursement Request must have at least 1 transaction to apply against'
            );
        }

        $xml->writeElement('documentnumber', $this->getDocumentNo());
        $xml->writeElement('paymentdescription', $this->getMemo());
        $xml->writeElement('paymentcontact', $this->getNotificationContactName());

        $xml->endElement(); //create_reimbursementrequest

        $xml->endElement(); //function
    }
}
