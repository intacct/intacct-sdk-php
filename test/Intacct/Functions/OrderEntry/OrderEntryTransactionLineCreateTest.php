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

namespace Intacct\Functions\OrderEntry;

use Intacct\Functions\InventoryControl\TransactionItemDetail;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\InventoryControl\OrderEntryTransactionLineCreate
 */
class OrderEntryTransactionLineCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sotransitem>
    <itemid>26323</itemid>
    <quantity>2340</quantity>
</sotransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new OrderEntryTransactionLineCreate();
        $entry->setItemId('26323');
        $entry->setQuantity(2340);

        $entry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamsOverrides(): void
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
    <renewalmacro>Quarterly</renewalmacro>
    <projectid>235</projectid>
    <customerid>23423434</customerid>
    <vendorid>797656</vendorid>
    <employeeid>90295</employeeid>
    <classid>243609</classid>
    <contractid>9062</contractid>
    <fulfillmentstatus>
        <deliverystatus>Complete</deliverystatus>
    </fulfillmentstatus>
    <taskno>9850</taskno>
    <billingtemplate>3525</billingtemplate>
</sotransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new OrderEntryTransactionLineCreate();
        $entry->setBundleNumber('092304');
        $entry->setItemId('26323');
        $entry->setItemDescription('Item Description');
        $entry->setTaxable(true);
        $entry->setWarehouseId('93294');
        $entry->setQuantity(2340);
        $entry->setUnit('593');
        $entry->setDiscountPercent(10.00);
        $entry->setPrice(32.35);
        $entry->setDiscountSurchargeMemo('None');
        $entry->setMemo('Memo');
        $entry->setRevRecTemplate('template');
        $entry->setRevRecStartDate(new \DateTime('2015-06-30'));
        $entry->setRevRecEndDate(new \DateTime('2015-07-31'));
        $entry->setRenewalMacro('Quarterly');

        $fulfillmentStatus = new FulfillmentStatusCreate();
        $fulfillmentStatus->setDeliveryStatus('Complete');

        $entry->setFulfillmentStatus($fulfillmentStatus);
        $entry->setTaskNumber('9850');
        $entry->setBillingTemplate('3525');
        $entry->setLocationId('SF');
        $entry->setDepartmentId('Receiving');
        $entry->setProjectId('235');
        $entry->setCustomerId('23423434');
        $entry->setVendorId('797656');
        $entry->setEmployeeId('90295');
        $entry->setClassId('243609');
        $entry->setContractId('9062');

        $itemDetail1 = new TransactionItemDetail();
        $itemDetail1->setQuantity(52);
        $itemDetail1->setLotNumber('3243');

        $entry->setItemDetails([
            $itemDetail1,
        ]);
        $entry->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $entry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testKitStatus(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sotransitem>
    <itemid>26323</itemid>
    <quantity>2340</quantity>
    <fulfillmentstatus>
        <kitstatus>
            <line_num>14</line_num>
            <invoiceprice>700.5</invoiceprice>
            <deliverystatus>Undelivered</deliverystatus>
            <deliverydate>
                <year>2018</year>
                <month>12</month>
                <day>25</day>
            </deliverydate>
            <deferralstatus>Defer until item is delivered</deferralstatus>
        </kitstatus>
    </fulfillmentstatus>
</sotransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new OrderEntryTransactionLineCreate();
        $entry->setItemId('26323');
        $entry->setQuantity(2340);

        $kitStatus = new KitStatusCreate();
        $kitStatus->setInvoicePrice(700.50);
        $kitStatus->setLineNo(14);
        $kitStatus->setDeliveryDate(new \DateTime('2018/12/25'));
        $kitStatus->setDeliveryStatus('Undelivered');
        $kitStatus->setDeferralStatus('Defer until item is delivered');
        $entry->setFulfillmentStatus($kitStatus);
        $entry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
