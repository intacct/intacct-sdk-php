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
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\InventoryControl\InventoryTransactionCreate
 */
class InventoryTransactionCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_ictransaction>
        <transactiontype>Purchase Order</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <ictransitems>
            <ictransitem>
                <itemid>02354032</itemid>
                <warehouseid>W1234</warehouseid>
                <quantity>1200</quantity>
            </ictransitem>
        </ictransitems>
    </create_ictransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new InventoryTransactionCreate('unittest');
        $transaction->setTransactionDefinition('Purchase Order');
        $transaction->setTransactionDate(new \DateTime('2015-06-30'));

        $line1 = new InventoryTransactionLineCreate();
        $line1->setItemId('02354032');
        $line1->setWarehouseId('W1234');
        $line1->setQuantity(1200);

        $transaction->setLines([
            $line1,
        ]);

        $transaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_ictransaction>
        <transactiontype>Inventory Shipper</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <createdfrom>Inventory Shipper-P1002</createdfrom>
        <documentno>23430</documentno>
        <referenceno>234235</referenceno>
        <message>Submit</message>
        <externalid>20394</externalid>
        <basecurr>USD</basecurr>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <state>Pending</state>
        <ictransitems>
            <ictransitem>
                <itemid>2390552</itemid>
                <warehouseid>W1234</warehouseid>
                <quantity>223</quantity>
            </ictransitem>
        </ictransitems>
        <subtotals>
            <subtotal>
                <description>Subtotal description</description>
                <total>223</total>
            </subtotal>
        </subtotals>
    </create_ictransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new InventoryTransactionCreate('unittest');
        $transaction->setTransactionDefinition('Inventory Shipper');
        $transaction->setTransactionDate(new \DateTime('2015-06-30'));
        $transaction->setCreatedFrom('Inventory Shipper-P1002');
        $transaction->setDocumentNumber('23430');
        $transaction->setReferenceNumber('234235');
        $transaction->setMessage('Submit');
        $transaction->setExternalId('20394');
        $transaction->setBaseCurrency('USD');
        $transaction->setState('Pending');
        $transaction->setCustomFields([
            'customfield1' => 'customvalue1'
        ]);

        $line1 = new InventoryTransactionLineCreate();
        $line1->setItemId('2390552');
        $line1->setWarehouseId('W1234');
        $line1->setQuantity(223);

        $transaction->setLines([
            $line1,
        ]);

        $subtotal1 = new TransactionSubtotalCreate();
        $subtotal1->setDescription('Subtotal description');
        $subtotal1->setTotal(223);
        $transaction->setSubtotals([
            $subtotal1,
        ]);

        $transaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingPurchasingTransactionEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("IC Transaction must have at least 1 line");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new InventoryTransactionCreate('unittest');
        $transaction->setTransactionDefinition('Purchase Order');
        $transaction->setTransactionDate(new \DateTime('2015-06-30'));

        $transaction->writeXml($xml);
    }
}
