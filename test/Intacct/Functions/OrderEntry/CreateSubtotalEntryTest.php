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

namespace Intacct\Functions\OrderEntry;

use Intacct\Xml\XMLWriter;

class CreateSubtotalEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\OrderEntry\CreateSubtotalEntry::__construct
     * @covers Intacct\Functions\OrderEntry\CreateSubtotalEntry::getXml
     */
    public function testDefaultParams()
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

        $subtotalEntry = new CreateSubtotalEntry([
            'description' => 'Subtotal Description',
            'total' => 2340,
        ]);

        $subtotalEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\OrderEntry\CreateSubtotalEntry::__construct
     * @covers Intacct\Functions\OrderEntry\CreateSubtotalEntry::getXml
     */
    public function testParamsOverrides()
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

        $subtotalEntry = new CreateSubtotalEntry([
            'description' => 'Subtotal Description',
            'total' => '4202',
            'percentage_value' => 9.2,
            'location_id' => 2355,
            'department_id' => 'RCVNG',
            'project_id' => 'FOW',
            'customer_id' => 'CUST5893',
            'vendor_id' => 'VEN53222',
            'employee_id' => 'EM5925',
            'class_id' => 'CLS322',
            'item_id' => 'I5266235',
            'contract_id' => 'C23662',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
        ]);

        $subtotalEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
