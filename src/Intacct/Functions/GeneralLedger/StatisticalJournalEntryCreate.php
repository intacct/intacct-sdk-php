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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new statistical journal entry record
 */
class StatisticalJournalEntryCreate extends AbstractStatisticalJournalEntry
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

        $xml->startElement('create');
        $xml->startElement('GLBATCH');

        $xml->writeElement('JOURNAL', $this->getJournalSymbol(), true);
        $xml->writeElementDate('BATCH_DATE', $this->getPostingDate(), $xml::IA_DATE_FORMAT, true);
        $xml->writeElementDate('REVERSEDATE', $this->getReverseDate());
        $xml->writeElement('BATCH_TITLE', $this->getDescription(), true);
        $xml->writeElement('HISTORY_COMMENT', $this->getHistoryComment());
        $xml->writeElement('REFERENCENO', $this->getReferenceNumber());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('STATE', $this->getAction());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->startElement('ENTRIES');
        if (count($this->getLines()) >= 1) {
            foreach ($this->getLines() as $entry) {
                $entry->writeXml($xml);
            }
        } else {
            throw new InvalidArgumentException('Statistical Journal Entry must have at least 1 line');
        }
        $xml->endElement(); //ENTRIES

        $xml->endElement(); //GLBATCH
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
