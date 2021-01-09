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

/**
 * @coversDefaultClass \Intacct\Functions\EmployeeExpense\ExpenseReportLineCreate
 */
class ExpenseReportLineCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<expense>
    <glaccountno></glaccountno>
</expense>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $line = new ExpenseReportLineCreate();

        $line->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<expense>
    <glaccountno>7000</glaccountno>
    <amount>1025.99</amount>
    <currency>USD</currency>
    <trx_amount>76343.43</trx_amount>
    <exchratedate>
        <year>2016</year>
        <month>06</month>
        <day>30</day>
    </exchratedate>
    <exchratetype>Intacct Daily Rate</exchratetype>
    <expensedate>
        <year>2016</year>
        <month>06</month>
        <day>30</day>
    </expensedate>
    <memo>Marriott</memo>
    <form1099>true</form1099>
    <form1099type>1099-MISC</form1099type>
    <form1099box>3</form1099box>
    <paidfor>Hotel</paidfor>
    <locationid>Location1</locationid>
    <departmentid>Department1</departmentid>
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
    <contractid>Contract1</contractid>
    <warehouseid>Warehouse1</warehouseid>
    <billable>true</billable>
    <exppmttype>AMEX</exppmttype>
    <quantity>10</quantity>
    <rate>12.34</rate>
</expense>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $line = new ExpenseReportLineCreate();
        $line->setGlAccountNumber('7000');
        $line->setReimbursementAmount(1025.99);
        $line->setTransactionCurrency('USD');
        $line->setTransactionAmount(76343.43);
        $line->setExchangeRateDate(new \DateTime('2016-06-30'));
        $line->setExchangeRateType('Intacct Daily Rate');
        $line->setExpenseDate(new \DateTime('2016-06-30'));
        $line->setPaidTo('Marriott');
        $line->setPaidFor('Hotel');
        $line->setForm1099(true);
        $line->setForm1099type('1099-MISC');
        $line->setForm1099box('3');
        $line->setBillable(true);
        $line->setPaymentTypeName('AMEX');
        $line->setQuantity(10);
        $line->setUnitRate(12.34);
        $line->setLocationId('Location1');
        $line->setDepartmentId('Department1');
        $line->setProjectId('Project1');
        $line->setCustomerId('Customer1');
        $line->setVendorId('Vendor1');
        $line->setEmployeeId('Employee1');
        $line->setItemId('Item1');
        $line->setClassId('Class1');
        $line->setContractId('Contract1');
        $line->setWarehouseId('Warehouse1');
        $line->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $line->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
