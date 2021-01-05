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
 * Create a new employee expense report record
 */
class ExpenseReportCreate extends AbstractExpenseReport
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

        $xml->startElement('create_expensereport');

        $xml->writeElement('employeeid', $this->getEmployeeId(), true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate());
        $xml->endElement(); //datecreated

        if ($this->getGlPostingDate()) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('batchkey', $this->getSummaryRecordNo());
        $xml->writeElement('expensereportno', $this->getExpenseReportNumber());
        $xml->writeElement('state', $this->getAction());
        $xml->writeElement('description', $this->getReasonForExpense());
        $xml->writeElement('memo', $this->getMemo());
        $xml->writeElement('externalid', $this->getExternalId());
        $xml->writeElement('basecurr', $this->getBaseCurrency());
        $xml->writeElement('currency', $this->getReimbursementCurrency());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('supdocid', $this->getAttachmentsId());

        $xml->startElement('expenses');
        if (count($this->getLines()) > 0) {
            foreach ($this->getLines() as $line) {
                $line->writeXml($xml);
            }
        } else {
            throw new InvalidArgumentException('EE Report must have at least 1 line');
        }
        $xml->endElement(); //expenses

        $xml->endElement(); //create_expensereport

        $xml->endElement(); //function
    }
}
