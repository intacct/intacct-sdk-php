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

class TimesheetUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function testParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update>
        <TIMESHEET>
            <RECORDNO>1234</RECORDNO>
            <EMPLOYEEID>E1234</EMPLOYEEID>
            <BEGINDATE>06/30/2016</BEGINDATE>
            <TIMESHEETENTRIES>
                <TIMESHEETENTRY>
                    <RECORDNO>1</RECORDNO>
                    <ENTRYDATE>06/30/2016</ENTRYDATE>
                    <QTY>5</QTY>
                </TIMESHEETENTRY>
            </TIMESHEETENTRIES>
        </TIMESHEET>
    </update>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetUpdate('unittest');
        $record->setRecordNo('1234');
        $record->setEmployeeId('E1234');
        $record->setBeginDate(new \DateTime('2016-06-30'));

        $entry1 = new TimesheetEntryUpdate();
        $entry1->setLineRecordNo('1');
        $entry1->setEntryDate(new \DateTime('2016-06-30'));
        $entry1->setQuantity(5);

        $record->setEntries([
            $entry1,
        ]);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}