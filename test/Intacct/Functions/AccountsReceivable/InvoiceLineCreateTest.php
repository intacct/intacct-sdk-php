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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\InvoiceLineCreate
 */
class InvoiceLineCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
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

        $line = new InvoiceLineCreate();
        $line->setTransactionAmount(76343.43);

        $line->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<lineitem>
    <accountlabel>TestBill Account1</accountlabel>
    <offsetglaccountno>93590253</offsetglaccountno>
    <amount>76343.43</amount>
    <memo>Just another memo</memo>
    <locationid>Location1</locationid>
    <departmentid>Department1</departmentid>
    <key>Key1</key>
    <totalpaid>23484.93</totalpaid>
    <totaldue>0</totaldue>
    <customfields>
        <customfield>
            <customfieldname>customfield1</customfieldname>
            <customfieldvalue>customvalue1</customfieldvalue>
        </customfield>
    </customfields>
    <revrectemplate>RevRec1</revrectemplate>
    <defrevaccount>2100</defrevaccount>
    <revrecstartdate>
        <year>2016</year>
        <month>06</month>
        <day>01</day>
    </revrecstartdate>
    <revrecenddate>
        <year>2017</year>
        <month>05</month>
        <day>31</day>
    </revrecenddate>
    <projectid>Project1</projectid>
    <customerid>Customer1</customerid>
    <vendorid>Vendor1</vendorid>
    <employeeid>Employee1</employeeid>
    <itemid>Item1</itemid>
    <classid>Class1</classid>
    <warehouseid>Warehouse1</warehouseid>
    <taxentries>
        <taxentry>
            <detailid>TaxName</detailid>
            <trx_tax>10</trx_tax>
        </taxentry>
    </taxentries>
</lineitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $line = new InvoiceLineCreate();
        $line->setAccountLabel('TestBill Account1');
        $line->setOffsetGLAccountNumber('93590253');
        $line->setTransactionAmount(76343.43);
        $line->setMemo('Just another memo');
        $line->setKey('Key1');
        $line->setTotalPaid(23484.93);
        $line->setTotalDue(0.00);
        $line->setRevRecTemplateId('RevRec1');
        $line->setDeferredRevGlAccountNo('2100');
        $line->setRevRecStartDate(new \DateTime('2016-06-01'));
        $line->setRevRecEndDate(new \DateTime('2017-05-31'));
        $line->setLocationId('Location1');
        $line->setDepartmentId('Department1');
        $line->setProjectId('Project1');
        $line->setCustomerId('Customer1');
        $line->setVendorId('Vendor1');
        $line->setEmployeeId('Employee1');
        $line->setItemId('Item1');
        $line->setClassId('Class1');
        $line->setWarehouseId('Warehouse1');
        $line->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $taxEntries = new InvoiceLineTaxEntriesCreate();
        $taxEntries->setTaxId('TaxName');
        $taxEntries->setTaxValue(10);

        $line->setTaxEntry([$taxEntries]);

        $line->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
