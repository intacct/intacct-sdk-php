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

/**
 * @coversDefaultClass \Intacct\Functions\Projects\TimesheetEntryCreate
 */
class TimesheetEntryCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<TIMESHEETENTRY>
    <ENTRYDATE>06/30/2016</ENTRYDATE>
    <QTY></QTY>
</TIMESHEETENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $line = new TimesheetEntryCreate();
        $line->setEntryDate(new \DateTime('2016-06-30'));

        $line->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
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

        $line = new TimesheetEntryCreate();
        $line->setEntryDate(new \DateTime('2016-06-30'));
        $line->setQuantity(1.75);
        $line->setDescription('desc');
        $line->setNotes('my note');
        $line->setTaskRecordNo(1234);
        $line->setTimeTypeName('Salary');
        $line->setBillable(true);
        $line->setOverrideBillingRate(200.00);
        $line->setOverrideLaborCostRate(175.00);
        $line->setDepartmentId('ADM');
        $line->setLocationId('100');
        $line->setProjectId('P100');
        $line->setCustomerId('C100');
        $line->setVendorId('V100');
        $line->setItemId('I100');
        $line->setClassId('C200');
        $line->setContractId('C300');
        $line->setWarehouseId('W100');

        $line->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $line->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
