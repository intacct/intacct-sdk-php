<?php
/**
 *
 * *
 *  * Copyright 2016 Intacct Corporation.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  * use this file except in compliance with the License. You may obtain a copy
 *  * of the License at
 *  *
 *  * http://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * or in the "LICENSE" file accompanying this file. This file is distributed on
 *  * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 *  * express or implied. See the License for the specific language governing
 *  * permissions and limitations under the License.
 *
 *
 */

namespace Intacct\Functions\Purchasing;

use Intacct\Xml\XMLWriter;
use Intacct\Functions\CreateItemDetail;

class CreatePurchasingTransactionEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Purchasing\CreatePurchasingTransactionEntry::__construct
     * @covers Intacct\Functions\Purchasing\CreatePurchasingTransactionEntry::getXml
     * @covers Intacct\Functions\Purchasing\CreatePurchasingTransactionEntry::getItemDetails
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<potransitem>
    <itemid>26323</itemid>
    <quantity>2340</quantity>
    <itemdetails>
        <itemdetail>
            <quantity>2340</quantity>
        </itemdetail>
    </itemdetails>
</potransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $itemDetail = new CreateItemDetail([
            'quantity' => 2340,
        ]);

        $purchasingTransactionEntry = new CreatePurchasingTransactionEntry([
            'item_id' => '26323',
            'quantity' => 2340,
            'item_details' => [
              $itemDetail,
            ],
        ]);

        $purchasingTransactionEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Purchasing\CreatePurchasingTransactionEntry::__construct
     * @covers Intacct\Functions\Purchasing\CreatePurchasingTransactionEntry::getXml
     * @covers Intacct\Functions\Purchasing\CreatePurchasingTransactionEntry::getItemDetails
     */
    public function testParamsOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<potransitem>
    <itemid>26323</itemid>
    <itemdesc>Item Description</itemdesc>
    <taxable>true</taxable>
    <warehouseid>93294</warehouseid>
    <quantity>2340</quantity>
    <unit>593</unit>
    <price>32.35</price>
    <overridetaxamount>0.0</overridetaxamount>
    <tax>9.23</tax>
    <locationid>SF</locationid>
    <departmentid>Purchasing</departmentid>
    <memo>Memo</memo>
    <itemdetails>
        <itemdetail>
            <quantity>52</quantity>
            <lotno>3243</lotno>
        </itemdetail>
    </itemdetails>
    <form1099>true</form1099>
    <customfields>
        <customfield>
            <customfieldname>customfield1</customfieldname>
            <customfieldvalue>customvalue1</customfieldvalue>
        </customfield>
    </customfields>
    <projectid>235</projectid>
    <customerid>23423434</customerid>
    <vendorid>797656</vendorid>
    <employeeid>90295</employeeid>
    <classid>243609</classid>
    <contractid>9062</contractid>
    <billable>true</billable>
</potransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $purchasingTransactionEntry = new CreatePurchasingTransactionEntry([
            'item_id' => '26323',
            'item_description' => 'Item Description',
            'taxable' => true,
            'warehouse_id' => 93294,
            'quantity' => 2340,
            'unit' => 593,
            'price' => 32.35,
            'override_tax_amount' => '0.0',
            'tax' => '9.23',
            'location_id' => 'SF',
            'department_id' => 'Purchasing',
            'memo' => 'Memo',
            'item_details' => [
                [
                    'quantity' => 52,
                    'lot_number' => 3243
                ]
            ],
            'form1099' => 'true',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'project_id' => '235',
            'customer_id' => '23423434',
            'vendor_id' => '797656',
            'employee_id' => 90295,
            'class_id' => 243609,
            'contract_id' => 9062,
            'billable' => 'true',
        ]);

        $purchasingTransactionEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}