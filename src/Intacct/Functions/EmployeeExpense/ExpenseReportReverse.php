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

class ExpenseReportReverse extends AbstractExpenseReport
{

    /** @var \DateTime */
    protected $reverseDate;

    /** @var string */
    protected $memo;

    /**
     * @return \DateTime
     */
    public function getReverseDate()
    {
        return $this->reverseDate;
    }

    /**
     * @param \DateTime $reverseDate
     */
    public function setReverseDate($reverseDate)
    {
        $this->reverseDate = $reverseDate;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

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

        $xml->startElement('reverse_expensereport');

        if (!$this->getRecordNo()) {
            throw new InvalidArgumentException('Record No is required for reverse');
        }
        $xml->writeAttribute('key', $this->getRecordNo());

        if (!$this->getReverseDate()) {
            throw new InvalidArgumentException('Reverse Date is required for reverse');
        }
        $xml->startElement('datereversed');
        $xml->writeDateSplitElements($this->getReverseDate());
        $xml->endElement(); //datereversed

        $xml->writeElement('description', $this->getMemo());

        $xml->endElement(); //reverse_expensereport

        $xml->endElement(); //function
    }
}
