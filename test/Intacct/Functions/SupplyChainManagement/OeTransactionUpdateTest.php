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

class OeTransactionUpdateTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\SupplyChainManagement\OeTransactionUpdate::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update_sotransaction key="Sales Order-SO0001"/>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new OeTransactionUpdate('unittest');
        $transaction->setTransactionId('Sales Order-SO0001');

        $transaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\OeTransactionUpdate::writeXml
     */
    public function testEntriesSubtotals()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update_sotransaction key="Sales Order-SO0001">
        <updatesotransitems>
            <updatesotransitem line_num="1">
                <itemid>02354032</itemid>
                <quantity>12</quantity>
            </updatesotransitem>
            <sotransitem>
                <itemid>02354032</itemid>
                <quantity>1200</quantity>
            </sotransitem>
        </updatesotransitems>
        <updatesubtotals>
            <updatesubtotal>
                <description>Subtotal Description</description>
                <total>1200</total>
            </updatesubtotal>
        </updatesubtotals>
    </update_sotransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new OeTransactionUpdate('unittest');
        $transaction->setTransactionId('Sales Order-SO0001');


        $line1 = new OeTransactionLineUpdate();
        $line1->setLineNo(1);
        $line1->setItemId('02354032');
        $line1->setQuantity(12);

        $line2 = new OeTransactionLineCreate();
        $line2->setItemId('02354032');
        $line2->setQuantity(1200);

        $transaction->setLines([
            $line1,
            $line2,
        ]);

        $subtotal1 = new TransactionSubtotalUpdate();
        $subtotal1->setDescription('Subtotal Description');
        $subtotal1->setTotal(1200);
        $transaction->setSubtotals([
            $subtotal1,
        ]);

        $transaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SupplyChainManagement\OeTransactionUpdate::writeXml
      */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update_sotransaction key="Sales Order-SO0001">
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
        <referenceno>234235</referenceno>
        <termname>N30</termname>
        <datedue>
            <year>2020</year>
            <month>09</month>
            <day>24</day>
        </datedue>
        <origdocdate>
            <year>2015</year>
            <month>06</month>
            <day>15</day>
        </origdocdate>
        <message>Submit</message>
        <shippingmethod>USPS</shippingmethod>
        <shipto>
            <contactname>28952</contactname>
        </shipto>
        <billto>
            <contactname>289533</contactname>
        </billto>
        <supdocid>6942</supdocid>
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
    </update_sotransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new OeTransactionUpdate('unittest');
        $transaction->setTransactionId('Sales Order-SO0001');
        $transaction->setTransactionDate(new Date('2015-06-30'));
        $transaction->setGlPostingDate(new Date('2015-06-30'));
        $transaction->setOriginalDocumentDate(new Date('2015-06-15'));
        $transaction->setReferenceNumber('234235');
        $transaction->setPaymentTerm('N30');
        $transaction->setDueDate(new Date('2020-09-24'));
        $transaction->setMessage('Submit');
        $transaction->setShippingMethod('USPS');
        $transaction->setShipToContactName('28952');
        $transaction->setBillToContactName('289533');
        $transaction->setAttachmentsId('6942');
        $transaction->setBaseCurrency('USD');
        $transaction->setTransactionCurrency('USD');
        $transaction->setExchangeRateDate(new Date('2015-06-30'));
        $transaction->setExchangeRateType('Intacct Daily Rate');
        $transaction->setVsoePriceList('VSOEPricing');
        $transaction->setCustomFields([
            'customfield1' => 'customvalue1'
        ]);
        $transaction->setState('Pending');
        $transaction->setProjectId('P2904');

        $transaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
