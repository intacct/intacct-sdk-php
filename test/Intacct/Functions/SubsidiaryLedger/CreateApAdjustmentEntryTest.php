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

class CreateApAdjustmentEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustmentEntry::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<lineitem>
    <glaccountno></glaccountno>
    <amount>76343.43</amount>
</lineitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBillEntry = new CreateApAdjustmentEntry([
            'transaction_amount' => 76343.43,
        ]);
        $apBillEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustmentEntry::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<lineitem>
    <accountlabel>TestBill Account1</accountlabel>
    <offsetglaccountno>93590253</offsetglaccountno>
    <amount>76343.43</amount>
    <allocationid>89cv23589</allocationid>
    <memo>Just another memo</memo>
    <locationid>fuion23iouhg443f23f232</locationid>
    <departmentid>Test Department</departmentid>
    <key>Key1</key>
    <totalpaid>23484.93</totalpaid>
    <totaldue>0</totaldue>
    <customfields>
        <customfield>
            <customfieldname>customfield1</customfieldname>
            <customfieldvalue>customvalue1</customfieldvalue>
        </customfield>
    </customfields>
    <projectid>Project1</projectid>
    <customerid>Customer1</customerid>
    <vendorid>Vendor1</vendorid>
    <employeeid>Employee1</employeeid>
    <itemid>Item1</itemid>
    <classid>Class1</classid>
    <warehouseid>Warehouse1</warehouseid>
</lineitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBillEntry = new CreateApAdjustmentEntry([
            'account_label' => 'TestBill Account1',
            'offset_gl_account_no' => 93590253,
            'transaction_amount' => 76343.43,
            'allocation_id' => '89cv23589',
            'memo' => 'Just another memo',
            'location_id' => 'fuion23iouhg443f23f232',
            'department_id' => 'Test Department',
            'key' => 'Key1',
            'total_paid' => 23484.93,
            'total_due' => 0.00,
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'project_id' => 'Project1',
            'customer_id' => 'Customer1',
            'vendor_id' => 'Vendor1',
            'employee_id' => 'Employee1',
            'item_id' => 'Item1',
            'class_id' => 'Class1',
            'warehouse_id' => 'Warehouse1',
        ]);
        $apBillEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustmentEntry::writeXml
     */
    public function testGLAccountNumber()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<lineitem>
    <glaccountno>23453252353</glaccountno>
    <amount>234.26</amount>
</lineitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBillEntry = new CreateApAdjustmentEntry([
            'gl_account_no' => 23453252353,
            'transaction_amount' => 234.26
        ]);
        $apBillEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
