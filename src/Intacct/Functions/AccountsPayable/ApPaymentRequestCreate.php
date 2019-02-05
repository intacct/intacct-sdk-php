<?php

/**
 * Copyright 2019 Sage Intacct, Inc.
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
use InvalidArgumentException;

/**
 * Create a new accounts payable payment request record
 */
class ApPaymentRequestCreate extends AbstractApPaymentRequest
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

        $xml->startElement('create_paymentrequest');

        if ($this->getChargeCardId()) {
            $xml->writeElement('chargecardid', $this->getChargeCardId(), true);
        } else {
            $xml->writeElement('bankaccountid', $this->getBankAccountId(), true);
        }

        if (!$this->getVendorId()) {
            throw new InvalidArgumentException('Vendor ID is required for create payment request');
        }
        $xml->writeElement('vendorid', $this->getVendorId(), true);

        $xml->writeElement('memo', $this->getMemo());

        if (!$this->getPaymentMethod()) {
            throw new InvalidArgumentException('Payment Method is required for create payment request');
        }
        $xml->writeElement('paymentmethod', $this->getPaymentMethod(), true);

        $xml->writeElement('grouppayments', $this->isGroupPayments());

        if (!$this->getPaymentDate()) {
            throw new InvalidArgumentException('Payment Date is required for create payment request');
        }
        $xml->startElement('paymentdate');
        $xml->writeDateSplitElements($this->getPaymentDate(), true);
        $xml->endElement(); //paymentdate

        $xml->writeElement('paymentoption', $this->getMergeOption());

        if (count($this->getApplyToTransactions()) > 0) {
            $xml->startElement('paymentrequestitems');
            foreach ($this->getApplyToTransactions() as $applyToTransaction) {
                $applyToTransaction->writeXml($xml);
            }
            $xml->endElement(); //paymentrequestitems
        } else {
            throw new InvalidArgumentException('AP Payment Request must have at least 1 transaction to apply against');
        }

        // TODO: what about paymentamount element? only in v3.0 schema - was removed from v2.1 schema

        $xml->writeElement('documentnumber', $this->getDocumentNo());

        // TODO: review paymentdescription vs memo
        $xml->writeElement('paymentdescription', $this->getMemo());

        $xml->writeElement('paymentcontact', $this->getNotificationContactName());

        $xml->endElement(); //create_paymentrequest

        $xml->endElement(); //function
    }
}
