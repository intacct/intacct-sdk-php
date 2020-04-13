<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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
 * Delete an existing journal entry record
 */
class JournalEntryDelete extends AbstractJournalEntry
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter $xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('delete');
        $xml->writeElement('object', 'GLBATCH');

        if ( ! $this->getRecordNo() ) {
            throw new InvalidArgumentException('Record No is required for delete');
        }
        $xml->writeElement('keys', $this->getRecordNo(), true);

        $xml->endElement(); //delete

        $xml->endElement(); //function
    }
}
