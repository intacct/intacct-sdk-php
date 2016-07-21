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

class CreateOrderEntryTransactionEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::__construct
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::getXml
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::setRevRecStartDate
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::setRevRecEndDate
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::getItemDetails
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sotransitem>
    <itemid>26323</itemid>
    <quantity>2340</quantity>
    <itemdetails>
        <itemdetail>
            <quantity>2340</quantity>
        </itemdetail>
    </itemdetails>
</sotransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $itemDetail = new CreateItemDetail([
            'quantity' => 2340,
        ]);

        $orderEntryTransactionEntry = new CreateOrderEntryTransactionEntry([
            'item_id' => '26323',
            'quantity' => 2340,
            'item_details' => [
              $itemDetail,
            ],
        ]);

        $orderEntryTransactionEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::__construct
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::getXml
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::setRevRecStartDate
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::setRevRecEndDate
     * @covers Intacct\Functions\OrderEntry\CreateOrderEntryTransactionEntry::getItemDetails
     */
    public function testParamsOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sotransitem>
    <bundlenumber>092304</bundlenumber>
    <itemid>26323</itemid>
    <itemdesc>Item Description</itemdesc>
    <taxable>true</taxable>
    <warehouseid>93294</warehouseid>
    <quantity>2340</quantity>
    <unit>593</unit>
    <discountpercent>10</discountpercent>
    <price>32.35</price>
    <discsurchargememo>None</discsurchargememo>
    <locationid>SF</locationid>
    <departmentid>Receiving</departmentid>
    <memo>Memo</memo>
    <itemdetails>
        <itemdetail>
            <quantity>52</quantity>
            <lotno>3243</lotno>
        </itemdetail>
    </itemdetails>
    <customfields>
        <customfield>
            <customfieldname>customfield1</customfieldname>
            <customfieldvalue>customvalue1</customfieldvalue>
        </customfield>
    </customfields>
    <revrectemplate>template</revrectemplate>
    <revrecstartdate>
        <year>2015</year>
        <month>06</month>
        <day>30</day>
    </revrecstartdate>
    <revrecenddate>
        <year>2015</year>
        <month>07</month>
        <day>31</day>
    </revrecenddate>
    <renewalmacro>29034</renewalmacro>
    <projectid>235</projectid>
    <customerid>23423434</customerid>
    <vendorid>797656</vendorid>
    <employeeid>90295</employeeid>
    <classid>243609</classid>
    <contractid>9062</contractid>
    <fulfillmentstatus>Complete</fulfillmentstatus>
    <taskno>9850</taskno>
    <billingtemplate>3525</billingtemplate>
</sotransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orderEntryTransactionEntry = new CreateOrderEntryTransactionEntry([
            'bundle_number' => '092304',
            'item_id' => '26323',
            'item_description' => 'Item Description',
            'taxable' => true,
            'warehouse_id' => 93294,
            'quantity' => 2340,
            'unit' => 593,
            'discount_percent' => '10',
            'price' => 32.35,
            'discount_surcharge_memo' => 'None',
            'location_id' => 'SF',
            'department_id' => 'Receiving',
            'memo' => 'Memo',
            'item_details' => [
                [
                    'quantity' => 52,
                    'lot_number' => 3243
                ]
            ],
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'rev_rec_template' => 'template',
            'rev_rec_start_date' => '2015-06-30',
            'rev_rec_end_date' => '2015-07-31',
            'renewal_macro' => '29034',
            'project_id' => '235',
            'customer_id' => '23423434',
            'vendor_id' => '797656',
            'employee_id' => 90295,
            'class_id' => 243609,
            'contract_id' => 9062,
            'fulfillment_status' => 'Complete',
            'task_number' => 9850,
            'billing_template' => '3525',
        ]);

        $orderEntryTransactionEntry->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
