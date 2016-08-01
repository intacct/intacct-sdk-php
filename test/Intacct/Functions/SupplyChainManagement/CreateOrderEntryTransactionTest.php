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

namespace Intacct\Functions\SupplyChainManagement;

use Intacct\Xml\XMLWriter;
use Intacct\Fields\Date;
use InvalidArgumentException;

class CreateOrderEntryTransactionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_sotransaction>
        <transactiontype>Sales Order</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <customerid>2530</customerid>
        <sotransitems>
            <sotransitem>
                <itemid>02354032</itemid>
                <quantity>1200</quantity>
            </sotransitem>
        </sotransitems>
    </create_sotransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orderEntryTransaction = new CreateOrderEntryTransaction([
            'control_id' => 'unittest',
            'transaction_definition' => 'Sales Order',
            'transaction_date' => new Date('2015-06-30'),
            'customer_id' => '2530',
            'entries' => [
                [
                    'item_id' => '02354032',
                    'quantity' => 1200
                ],
            ],
        ]);

        $orderEntryTransaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::writeXml
     */
    public function testSubtotalEntry()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_sotransaction>
        <transactiontype>Sales Order</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <customerid>2530</customerid>
        <sotransitems>
            <sotransitem>
                <itemid>02354032</itemid>
                <quantity>1200</quantity>
            </sotransitem>
        </sotransitems>
        <subtotals>
            <subtotal>
                <description>Subtotal Description</description>
                <total>1200</total>
            </subtotal>
        </subtotals>
    </create_sotransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orderEntryTransaction = new CreateOrderEntryTransaction([
            'control_id' => 'unittest',
            'transaction_definition' => 'Sales Order',
            'transaction_date' => new Date('2015-06-30'),
            'customer_id' => '2530',
            'entries' => [
                [
                    'item_id' => '02354032',
                    'quantity' => 1200
                ],
            ],
            'subtotals' => [
                [
                    'description' => 'Subtotal Description',
                    'total' => 1200
                ],
            ],
        ]);

        $orderEntryTransaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::writeXml
      */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_sotransaction>
        <transactiontype>Sales Order</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <dateposted>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </dateposted>
        <createdfrom>Sales Quote-Q1002</createdfrom>
        <customerid>23530</customerid>
        <documentno>23430</documentno>
        <origdocdate>
            <year>2015</year>
            <month>06</month>
            <day>15</day>
        </origdocdate>
        <referenceno>234235</referenceno>
        <termname>N30</termname>
        <datedue>
            <year>2020</year>
            <month>09</month>
            <day>24</day>
        </datedue>
        <message>Submit</message>
        <shippingmethod>USPS</shippingmethod>
        <shipto>
            <contactname>28952</contactname>
        </shipto>
        <billto>
            <contactname>289533</contactname>
        </billto>
        <supdocid>6942</supdocid>
        <externalid>20394</externalid>
        <basecurr>USD</basecurr>
        <currency>USD</currency>
        <exchratedate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <vsoepricelist>VSOEPricing</vsoepricelist>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <state>Pending</state>
        <projectid>P2904</projectid>
        <sotransitems>
            <sotransitem>
                <itemid>2390552</itemid>
                <quantity>223</quantity>
            </sotransitem>
        </sotransitems>
        <subtotals>
            <subtotal>
                <description>Subtotal description</description>
                <total>223</total>
            </subtotal>
        </subtotals>
    </create_sotransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orderEntryTransactionEntry = new CreateOrderEntryTransactionEntry([
            'item_id' => '2390552',
            'quantity' => '223'
        ]);

        $subtotalEntry = new CreateTransactionSubtotalEntry([
            'description' => 'Subtotal description',
            'total' => '223'
        ]);

        $orderEntryTransaction = new CreateOrderEntryTransaction([
            'control_id' => 'unittest',
            'transaction_definition' => 'Sales Order',
            'transaction_date' => new Date('2015-06-30'),
            'gl_posting_date' => new Date('2015-06-30'),
            'created_from' => 'Sales Quote-Q1002',
            'customer_id' => '23530',
            'document_number' => '23430',
            'original_document_date' => new Date('2015-06-15'),
            'reference_number' => '234235',
            'payment_term' => 'N30',
            'due_date' => new Date('2020-09-24'),
            'message' => 'Submit',
            'shipping_method' => 'USPS',
            'ship_to_contact_name' => '28952',
            'bill_to_contact_name' => '289533',
            'attachments_id' => '6942',
            'external_id' => '20394',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => new Date('2015-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'vsoe_price_list' => 'VSOEPricing',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'state' => CreateOrderEntryTransaction::STATE_PENDING,
            'project_id' => 'P2904',
            'entries' => [
                $orderEntryTransactionEntry,
            ],
            'subtotals' => [
                $subtotalEntry,
            ]

        ]);

        $orderEntryTransaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreateOrderEntryTransaction::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "entries" param must have at least 1 entry
     */
    public function testMissingOrderEntryTransactionEntries()
    {

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orderEntryTransaction = new CreateOrderEntryTransaction([
            'control_id' => 'unittest',
            'transaction_type' => 'Sales Order',
            'transaction_date' => new Date('2015-06-30'),
            'customer_id' => '2530',
        ]);

        $orderEntryTransaction->writeXml($xml);
    }
}
