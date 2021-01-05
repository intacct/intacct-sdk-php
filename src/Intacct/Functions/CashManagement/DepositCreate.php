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

namespace Intacct\Functions\CashManagement;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new cash management deposit record
 */
class DepositCreate extends AbstractDeposit
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('record_deposit');

        if (!$this->getBankAccountId()) {
            throw new InvalidArgumentException('Bank Account ID is required for deposit');
        }
        $xml->writeElement('bankaccountid', $this->getBankAccountId(), true);

        if (!$this->getDepositDate()) {
            throw new InvalidArgumentException('Deposit Date is required for deposit');
        }
        $xml->startElement('depositdate');
        $xml->writeDateSplitElements($this->getDepositDate(), true);
        $xml->endElement(); //depositdate

        if (!$this->getDepositSlipId()) {
            throw new InvalidArgumentException('Deposit Slip ID is required for deposit');
        }
        $xml->writeElement('depositid', $this->getDepositSlipId(), true);

        $xml->startElement('receiptkeys');
        if (count($this->getTransactionKeysToDeposit()) > 0) {
            foreach ($this->getTransactionKeysToDeposit() as $key) {
                $xml->writeElement('receiptkey', $key, true);
            }
        } else {
            throw new InvalidArgumentException('CM Deposit must have at least 1 transaction key to deposit');
        }
        $xml->endElement(); //receiptkeys

        $xml->writeElement('description', $this->getDescription());
        $xml->writeElement('supdocid', $this->getAttachmentsId());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->endElement(); //record_deposit

        $xml->endElement(); //function
    }
}
