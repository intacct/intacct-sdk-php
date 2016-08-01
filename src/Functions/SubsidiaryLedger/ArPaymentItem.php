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

namespace Intacct\Functions\SubsidiaryLedger;

use Intacct\Xml\XMLWriter;

class ArPaymentItem
{

    /** @var string|int */
    private $applyToRecordId;

    /** @var float|string */
    private $amountToApply;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $apply_to_record_no
     *      @var string $amount_to_apply
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'apply_to_record_no' => null,
            'amount_to_apply' => null,
        ];

        $config = array_merge($defaults, $params);

        $this->applyToRecordId = $config['apply_to_record_no'];
        $this->amountToApply = $config['amount_to_apply'];
    }

    /**
     * Write the arpaymentitem block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('arpaymentitem');

        $xml->writeElement('invoicekey', $this->applyToRecordId, true);
        $xml->writeElement('amount', $this->amountToApply, true);

        $xml->endElement(); //arpaymentitem
    }
}
