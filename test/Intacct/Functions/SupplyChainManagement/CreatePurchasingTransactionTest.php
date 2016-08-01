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

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreatePurchasingTransactionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_potransaction>
        <transactiontype>Purchasing</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <vendorid>2530</vendorid>
        <datedue>
            <year>2019</year>
            <month>09</month>
            <day>15</day>
        </datedue>
        <returnto>
            <contactname></contactname>
        </returnto>
        <payto>
            <contactname></contactname>
        </payto>
        <potransitems>
            <potransitem>
                <itemid>02354032</itemid>
                <quantity>1200</quantity>
            </potransitem>
        </potransitems>
    </create_potransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $purchasingTransaction = new CreatePurchasingTransaction([
            'control_id' => 'unittest',
            'transaction_definition' => 'Purchasing',
            'transaction_date' => new Date('2015-06-30'),
            'vendor_id' => '2530',
            'due_date' => new Date('2019-09-15'),
            'entries' => [
                [
                    'item_id' => '02354032',
                    'quantity' => 1200
                ],
            ],
        ]);

        $purchasingTransaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::writeXml
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::getSubtotalEntries
     */
    public function testSubtotalEntry()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_potransaction>
        <transactiontype>Purchasing</transactiontype>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <vendorid>2530</vendorid>
        <datedue>
            <year>2015</year>
            <month>07</month>
            <day>31</day>
        </datedue>
        <returnto>
            <contactname>Bobbi Reese</contactname>
        </returnto>
        <payto>
            <contactname>Henry Jones</contactname>
        </payto>
        <potransitems>
            <potransitem>
                <itemid>02354032</itemid>
                <quantity>1200</quantity>
            </potransitem>
        </potransitems>
        <subtotals>
            <subtotal>
                <description>Subtotal Description</description>
                <total>1200</total>
            </subtotal>
        </subtotals>
    </create_potransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $purchasingTransaction = new CreatePurchasingTransaction([
            'control_id' => 'unittest',
            'transaction_definition' => 'Purchasing',
            'transaction_date' => new Date('2015-06-30'),
            'vendor_id' => '2530',
            'due_date' => new Date('2015-07-31'),
            'return_to_contact_name' => 'Bobbi Reese',
            'pay_to_contact_name' => 'Henry Jones',
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

        $purchasingTransaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::writeXml
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::getSubtotalEntries
      */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_potransaction>
        <transactiontype>Purchasing</transactiontype>
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
        <createdfrom>Purchasing-P1002</createdfrom>
        <vendorid>23530</vendorid>
        <documentno>23430</documentno>
        <referenceno>234235</referenceno>
        <termname>N30</termname>
        <datedue>
            <year>2020</year>
            <month>09</month>
            <day>24</day>
        </datedue>
        <message>Submit</message>
        <shippingmethod>USPS</shippingmethod>
        <returnto>
            <contactname>Bobbi Reese</contactname>
        </returnto>
        <payto>
            <contactname>Henry Jones</contactname>
        </payto>
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
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <state>Pending</state>
        <potransitems>
            <potransitem>
                <itemid>2390552</itemid>
                <quantity>223</quantity>
            </potransitem>
        </potransitems>
        <subtotals>
            <subtotal>
                <description>Subtotal description</description>
                <total>223</total>
            </subtotal>
        </subtotals>
    </create_potransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $purchasingTransactionEntry = new CreatePurchasingTransactionEntry([
            'item_id' => '2390552',
            'quantity' => '223'
        ]);

        $subtotalEntry = new CreateTransactionSubtotalEntry([
            'description' => 'Subtotal description',
            'total' => '223'
        ]);

        $purchasingTransaction = new CreatePurchasingTransaction([
            'control_id' => 'unittest',
            'transaction_definition' => 'Purchasing',
            'transaction_date' => new Date('2015-06-30'),
            'gl_posting_date' => new Date('2015-06-30'),
            'created_from' => 'Purchasing-P1002',
            'vendor_id' => '23530',
            'document_number' => '23430',
            'reference_number' => '234235',
            'payment_term' => 'N30',
            'due_date' => new Date('2020-09-24'),
            'message' => 'Submit',
            'shipping_method' => 'USPS',
            'return_to_contact_name' => 'Bobbi Reese',
            'pay_to_contact_name' => 'Henry Jones',
            'attachments_id' => '6942',
            'external_id' => '20394',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => new Date('2015-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'state' => CreatePurchasingTransaction::STATE_PENDING,
            'entries' => [
                $purchasingTransactionEntry,
            ],
            'subtotals' => [
                $subtotalEntry,
            ]

        ]);

        $purchasingTransaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Missing required "due_date" param
     */
    public function testMissingDueDate()
    {

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $purchasingTransaction = new CreatePurchasingTransaction([
            'control_id' => 'unittest',
            'transaction_type' => 'Sales Order',
            'transaction_date' => new Date('2015-06-30'),
            'vendor_id' => '2530',
            'return_to_contact_name' => 'Bobbi Reese',
            'pay_to_contact_name' => 'Henry Jones',
        ]);

        $purchasingTransaction->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::__construct
     * @covers Intacct\Functions\SupplyChainManagement\CreatePurchasingTransaction::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "entries" param must have at least 1 entry
     */
    public function testMissingPurchasingTransactionEntries()
    {

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $purchasingTransaction = new CreatePurchasingTransaction([
            'control_id' => 'unittest',
            'transaction_type' => 'Sales Order',
            'transaction_date' => new Date('2015-06-30'),
            'vendor_id' => '2530',
            'due_date' => new Date('2016-01-01'),
            'return_to_contact_name' => 'Bobbi Reese',
            'pay_to_contact_name' => 'Henry Jones',
        ]);

        $purchasingTransaction->writeXml($xml);
    }
}
