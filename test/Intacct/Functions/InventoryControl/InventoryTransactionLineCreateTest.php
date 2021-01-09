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
 * @coversDefaultClass \Intacct\Functions\InventoryControl\InventoryTransactionLineCreate
 */
class InventoryTransactionLineCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<ictransitem>
    <itemid>26323</itemid>
    <warehouseid>W1234</warehouseid>
    <quantity>2340</quantity>
</ictransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new InventoryTransactionLineCreate();
        $entry->setItemId('26323');
        $entry->setWarehouseId('W1234');
        $entry->setQuantity(2340);

        $entry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamsOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<ictransitem>
    <itemid>26323</itemid>
    <itemdesc>Item Description</itemdesc>
    <warehouseid>93294</warehouseid>
    <quantity>2340</quantity>
    <unit>593</unit>
    <cost>32.35</cost>
    <locationid>SF</locationid>
    <departmentid>Purchasing</departmentid>
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
    <projectid>235</projectid>
    <customerid>23423434</customerid>
    <vendorid>797656</vendorid>
    <employeeid>90295</employeeid>
    <classid>243609</classid>
    <contractid>9062</contractid>
</ictransitem>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new InventoryTransactionLineCreate();
        $entry->setItemId('26323');
        $entry->setItemDescription('Item Description');
        $entry->setWarehouseId('93294');
        $entry->setQuantity(2340);
        $entry->setUnit('593');
        $entry->setCost(32.35);
        $entry->setLocationId('SF');
        $entry->setDepartmentId('Purchasing');
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
}
