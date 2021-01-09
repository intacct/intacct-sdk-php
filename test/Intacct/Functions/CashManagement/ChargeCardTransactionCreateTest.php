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

namespace Intacct\Functions\CashManagement;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\CashManagement\ChargeCardTransactionCreate
 */
class ChargeCardTransactionCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <record_cctransaction>
        <chargecardid>AMEX1234</chargecardid>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <ccpayitems>
            <ccpayitem>
                <glaccountno/>
                <paymentamount>76343.43</paymentamount>
            </ccpayitem>
        </ccpayitems>
    </record_cctransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ChargeCardTransactionCreate('unittest');
        $record->setChargeCardId('AMEX1234');
        $record->setTransactionDate(new \DateTime('2015-06-30'));

        $line1 = new ChargeCardTransactionLineCreate();
        $line1->setTransactionAmount(76343.43);

        $record->setLines([
            $line1,
        ]);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <record_cctransaction>
        <chargecardid>AMEX1234</chargecardid>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <referenceno>321</referenceno>
        <payee>Costco</payee>
        <description>Supplies</description>
        <supdocid>A1234</supdocid>
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
        <ccpayitems>
            <ccpayitem>
                <glaccountno/>
                <paymentamount>76343.43</paymentamount>
            </ccpayitem>
        </ccpayitems>
    </record_cctransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ChargeCardTransactionCreate('unittest');
        $record->setChargeCardId('AMEX1234');
        $record->setTransactionDate(new \DateTime('2015-06-30'));
        $record->setReferenceNumber('321');
        $record->setPayee('Costco');
        $record->setDescription('Supplies');
        $record->setAttachmentsId('A1234');
        $record->setTransactionCurrency('USD');
        $record->setExchangeRateDate(new \DateTime('2015-06-30'));
        $record->setExchangeRateType('Intacct Daily Rate');
        $record->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $line1 = new ChargeCardTransactionLineCreate();
        $line1->setTransactionAmount(76343.43);

        $record->setLines([
            $line1,
        ]);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingBillEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Charge Card Transaction must have at least 1 line");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ChargeCardTransactionCreate('unittest');
        $record->setChargeCardId('AMEX1234');
        $record->setTransactionDate(new \DateTime('2015-06-30'));

        $record->writeXml($xml);
    }
}
