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

namespace Intacct\Functions\InventoryControl;

use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\InventoryControl\TransactionSubtotalCreate
 */
class TransactionSubtotalCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<subtotal>
    <description>Subtotal Description</description>
    <total>2340</total>
</subtotal>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $subtotal = new TransactionSubtotalCreate();
        $subtotal->setDescription('Subtotal Description');
        $subtotal->setTotal(2340);

        $subtotal->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamsOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<subtotal>
    <description>Subtotal Description</description>
    <total>4202</total>
    <percentval>9.2</percentval>
    <locationid>2355</locationid>
    <departmentid>RCVNG</departmentid>
    <projectid>FOW</projectid>
    <customerid>CUST5893</customerid>
    <vendorid>VEN53222</vendorid>
    <employeeid>EM5925</employeeid>
    <classid>CLS322</classid>
    <itemid>I5266235</itemid>
    <contractid>C23662</contractid>
    <customfields>
        <customfield>
            <customfieldname>customfield1</customfieldname>
            <customfieldvalue>customvalue1</customfieldvalue>
        </customfield>
    </customfields>
</subtotal>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $subtotal = new TransactionSubtotalCreate();
        $subtotal->setDescription('Subtotal Description');
        $subtotal->setTotal(4202);
        $subtotal->setPercentageValue(9.2);
        $subtotal->setLocationId('2355');
        $subtotal->setDepartmentId('RCVNG');
        $subtotal->setProjectId('FOW');
        $subtotal->setCustomerId('CUST5893');
        $subtotal->setVendorId('VEN53222');
        $subtotal->setEmployeeId('EM5925');
        $subtotal->setClassId('CLS322');
        $subtotal->setItemId('I5266235');
        $subtotal->setContractId('C23662');
        $subtotal->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $subtotal->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
