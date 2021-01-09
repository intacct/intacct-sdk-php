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

class TimesheetEntryUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function testParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<TIMESHEETENTRY>
    <ENTRYDATE>06/30/2016</ENTRYDATE>
</TIMESHEETENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetEntryUpdate('unittest');
        $record->setEntryDate(new \DateTime('2016-06-30'));

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    public function testAllParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<TIMESHEETENTRY>
    <ENTRYDATE>06/30/2016</ENTRYDATE>
    <QTY>1.75</QTY>
    <DESCRIPTION>desc</DESCRIPTION>
    <NOTES>my note</NOTES>
    <TASKKEY>1234</TASKKEY>
    <TIMETYPE>Salary</TIMETYPE>
    <BILLABLE>true</BILLABLE>
    <EXTBILLRATE>200</EXTBILLRATE>
    <EXTCOSTRATE>175</EXTCOSTRATE>
    <DEPARTMENTID>ADM</DEPARTMENTID>
    <LOCATIONID>100</LOCATIONID>
    <PROJECTID>P100</PROJECTID>
    <CUSTOMERID>C100</CUSTOMERID>
    <VENDORID>V100</VENDORID>
    <ITEMID>I100</ITEMID>
    <CLASSID>C200</CLASSID>
    <CONTRACTID>C300</CONTRACTID>
    <WAREHOUSEID>W100</WAREHOUSEID>
    <customfield1>customvalue1</customfield1>
</TIMESHEETENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new TimesheetEntryUpdate('unittest');
        $record->setEntryDate(new \DateTime('2016-06-30'));
        $record->setQuantity(1.75);
        $record->setDescription('desc');
        $record->setNotes('my note');
        $record->setTaskRecordNo(1234);
        $record->setTimeTypeName('Salary');
        $record->setBillable(true);
        $record->setOverrideBillingRate (200);
        $record->setOverrideLaborCostRate(175);
        $record->setDepartmentId('ADM');
        $record->setLocationId('100');
        $record->setProjectId('P100');
        $record->setCustomerId('C100');
        $record->setVendorId('V100');
        $record->setItemId('I100');
        $record->setClassId('C200');
        $record->setContractId('C300');
        $record->setWarehouseId('W100');
        $record->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}