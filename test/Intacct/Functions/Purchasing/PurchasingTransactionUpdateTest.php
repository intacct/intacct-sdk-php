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

namespace Intacct\Functions\Purchasing;

use Intacct\Functions\InventoryControl\TransactionSubtotalUpdate;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Purchasing\PurchasingTransactionUpdate
 */
class PurchasingTransactionUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update_potransaction key="1234" />
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new PurchasingTransactionUpdate('unittest');
        $entry->setDocumentNumber('1234');

        $entry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamsOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
<update_potransaction key='20394' externalkey="true">
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
    <updatepotransitems>
        <updatepotransitem line_num="1">
            <itemid>02354032</itemid>
        </updatepotransitem>
        <potransitem>
            <itemid>2390552</itemid>
            <quantity>223</quantity>
        </potransitem>
    </updatepotransitems>
    <updatesubtotals>
        <updatesubtotal>
            <description>Subtotal description</description>
            <total>223</total>
        </updatesubtotal>
    </updatesubtotals>
</update_potransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $entry = new PurchasingTransactionUpdate('unittest');
        $entry->setExternalId('20394');
        $entry->setTransactionDate(new \DateTime('2015-06-30'));
        $entry->setGlPostingDate(new \DateTime('2015-06-30'));
        $entry->setReferenceNumber('234235');
        $entry->setPaymentTerm('N30');
        $entry->setDueDate(new \DateTime('2020-09-24'));
        $entry->setMessage('Submit');
        $entry->setShippingMethod('USPS');
        $entry->setReturnToContactName('Bobbi Reese');
        $entry->setPayToContactName('Henry Jones');
        $entry->setAttachmentsId('6942');
        $entry->setBaseCurrency('USD');
        $entry->setTransactionCurrency('USD');
        $entry->setExchangeRateDate(new \DateTime('2015-06-30'));
        $entry->setExchangeRateType('Intacct Daily Rate');
        $entry->setState('Pending');

        $entry->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $line1 = new PurchasingTransactionLineUpdate();
        $line1->setLineNo('1');
        $line1->setItemId('02354032');

        $line2 = new PurchasingTransactionLineCreate();
        $line2->setItemId('2390552');
        $line2->setQuantity('223');

        $entry->setLines([
            $line1,
            $line2
        ]);

        $subtotal1 = new TransactionSubtotalUpdate();
        $subtotal1->setDescription('Subtotal description');
        $subtotal1->setTotal(223);
        $entry->setSubtotals([
            $subtotal1,
        ]);

        $entry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
