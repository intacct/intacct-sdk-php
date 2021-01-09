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

class ReimbursementRequestItem
{

    /** @var string|int */
    private $applyToRecordId;

    /** @var float|string */
    private $amountToApply;

    /** @var float|string */
    private $creditToApply;

    /**
     * @return int|string
     */
    public function getApplyToRecordId()
    {
        return $this->applyToRecordId;
    }

    /**
     * @param int|string $applyToRecordId
     */
    public function setApplyToRecordId($applyToRecordId)
    {
        $this->applyToRecordId = $applyToRecordId;
    }

    /**
     * @return float|string
     */
    public function getAmountToApply()
    {
        return $this->amountToApply;
    }

    /**
     * @param float|string $amountToApply
     */
    public function setAmountToApply($amountToApply)
    {
        $this->amountToApply = $amountToApply;
    }

    /**
     * @return float|string
     */
    public function getCreditToApply()
    {
        return $this->creditToApply;
    }

    /**
     * @param float|string $creditToApply
     */
    public function setCreditToApply($creditToApply)
    {
        $this->creditToApply = $creditToApply;
    }

    /**
     * Write the paymentrequestitem block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('eppaymentrequestitem');

        $xml->writeElement('key', $this->getApplyToRecordId(), true);
        $xml->writeElement('paymentamount', $this->getAmountToApply(), true);

        $xml->writeElement('credittoapply', $this->getCreditToApply());

        $xml->endElement(); //eppaymentrequestitem
    }
}
