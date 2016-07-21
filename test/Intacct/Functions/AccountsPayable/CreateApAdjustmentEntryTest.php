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

namespace Intacct\Functions\AccountsPayable;

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class CreateApAdjustmentEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getXml
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
        $apBillEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setLocationId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getLocationId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setDepartmentId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getDepartmentId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setForm1099
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTotalPaid
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTotalDue
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setCustomFields
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getCustomFieldsXml
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setProjectId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getProjectId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setCustomerId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getCustomerId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setVendorId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getVendorId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setEmployeeId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getEmployeeId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setItemId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getItemId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setClassId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getClassId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setContractId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getContractId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setWarehouseId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getWarehouseId
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setBillable
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getXml
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
    <item1099>true</item1099>
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
    <billable>true</billable>
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
            'form_1099' => true,
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
            'billable' => true,
        ]);
        $apBillEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::getXml
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
        $apBillEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage transaction_amount is not a valid number
     */
    public function testMissingAmount()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new CreateApAdjustmentEntry([
        ]);
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setForm1099
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage form_1099 is not a valid bool
     */
    public function testInvalidForm1099()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new CreateApAdjustmentEntry([
            'transaction_amount' => 234.26,
            'form_1099' => '2902',
        ]);
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTotalPaid
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage total_paid is not a valid number
     */
    public function testInvalidTotalPaid()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new CreateApAdjustmentEntry([
            'transaction_amount' => 234.26,
            'total_paid' => '$2902',
        ]);
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTotalDue
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage total_due is not a valid number
     */
    public function testInvalidTotalDue()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new CreateApAdjustmentEntry([
            'transaction_amount' => 234.26,
            'total_due' => true,
        ]);
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setTransactionAmount
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustmentEntry::setBillable
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage billable is not a valid bool
     */
    public function testInvalidBillable()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new CreateApAdjustmentEntry([
            'transaction_amount' => 234.26,
            'billable' => 'true',
        ]);
    }
}
