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

namespace Intacct\Functions\Projects;


use Intacct\Xml\XMLWriter;

class TimesheetUpdate extends AbstractTimesheet
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

        $xml->startElement('update');
        $xml->startElement('TIMESHEET');

        $xml->writeElement('RECORDNO', $this->recordNo);

        if ($this->getEmployeeId()) {
            $xml->writeElement('EMPLOYEEID', $this->getEmployeeId(), true);
        }
        if ($this->getBeginDate()) {
            $xml->writeElementDate('BEGINDATE', $this->getBeginDate(), $xml::IA_DATE_FORMAT, true);
        }

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('STATE', $this->getAction());

        $xml->startElement('TIMESHEETENTRIES');
        if (count($this->getEntries()) > 0) {
            foreach ($this->getEntries() as $entry) {
                $entry->writeXml($xml);
            }
        }

        $xml->endElement(); //TIMESHEETENTRIES

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //TIMESHEET
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}