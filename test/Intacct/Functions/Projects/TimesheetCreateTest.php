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
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Projects\TimesheetCreate
 */
class TimesheetCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <TIMESHEET>
            <EMPLOYEEID>E1234</EMPLOYEEID>
            <BEGINDATE>06/30/2016</BEGINDATE>
            <TIMESHEETENTRIES>
                <TIMESHEETENTRY>
                    <ENTRYDATE>06/30/2016</ENTRYDATE>
                    <QTY>1.75</QTY>
                </TIMESHEETENTRY>
            </TIMESHEETENTRIES>
        </TIMESHEET>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetCreate('unittest');
        $record->setEmployeeId('E1234');
        $record->setBeginDate(new \DateTime('2016-06-30'));

        $entry1 = new TimesheetEntryCreate();
        $entry1->setEntryDate(new \DateTime('2016-06-30'));
        $entry1->setQuantity(1.75);

        $record->setEntries([
            $entry1,
        ]);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <TIMESHEET>
            <EMPLOYEEID>E1234</EMPLOYEEID>
            <BEGINDATE>06/30/2016</BEGINDATE>
            <DESCRIPTION>desc</DESCRIPTION>
            <SUPDOCID>A1234</SUPDOCID>
            <STATE>Submitted</STATE>
            <TIMESHEETENTRIES>
                <TIMESHEETENTRY>
                    <ENTRYDATE>06/30/2016</ENTRYDATE>
                    <QTY>1.75</QTY>
                </TIMESHEETENTRY>
            </TIMESHEETENTRIES>
            <customfield1>customvalue1</customfield1>
        </TIMESHEET>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetCreate('unittest');
        $record->setEmployeeId('E1234');
        $record->setBeginDate(new \DateTime('2016-06-30'));
        $record->setDescription('desc');
        $record->setAttachmentsId('A1234');
        $record->setAction('Submitted');
        $record->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $entry1 = new TimesheetEntryCreate();
        $entry1->setEntryDate(new \DateTime('2016-06-30'));
        $entry1->setQuantity(1.75);

        $record->setEntries([
            $entry1,
        ]);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredEmployeeId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Employee ID is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetCreate('unittest');

        $record->writeXml($xml);
    }

    public function testRequiredBeginDate(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Begin Date is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetCreate('unittest');
        $record->setEmployeeId('E1234');

        $record->writeXml($xml);
    }

    public function testRequiredEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Timesheet must have at least 1 entry");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetCreate('unittest');
        $record->setEmployeeId('E1234');
        $record->setBeginDate(new \DateTime('2016-06-30'));

        $record->writeXml($xml);
    }
}
