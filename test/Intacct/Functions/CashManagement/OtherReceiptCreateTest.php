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
 * @coversDefaultClass \Intacct\Functions\CashManagement\OtherReceiptCreate
 */
class OtherReceiptCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <record_otherreceipt>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <payee>Costco</payee>
        <receiveddate>
            <year>2015</year>
            <month>07</month>
            <day>01</day>
        </receiveddate>
        <paymentmethod>Printed Check</paymentmethod>
        <undepglaccountno>1000</undepglaccountno>
        <receiptitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </receiptitems>
    </record_otherreceipt>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new OtherReceiptCreate('unittest');
        $record->setTransactionDate(new \DateTime('2015-06-30'));
        $record->setPayer('Costco');
        $record->setReceiptDate(new \DateTime('2015-07-01'));
        $record->setPaymentMethod('Printed Check');
        $record->setUndepositedFundsGlAccountNo('1000');

        $line1 = new OtherReceiptLineCreate();
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
    <record_otherreceipt>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <payee>Costco</payee>
        <receiveddate>
            <year>2015</year>
            <month>07</month>
            <day>01</day>
        </receiveddate>
        <paymentmethod>Printed Check</paymentmethod>
        <bankaccountid>BA1234</bankaccountid>
        <depositdate>
            <year>2015</year>
            <month>07</month>
            <day>04</day>
        </depositdate>
        <refid>transno</refid>
        <description>my desc</description>
        <supdocid>A1234</supdocid>
        <currency>USD</currency>
        <exchratedate>
            <year>2015</year>
            <month>07</month>
            <day>04</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <receiptitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </receiptitems>
    </record_otherreceipt>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new OtherReceiptCreate('unittest');
        $record->setTransactionDate(new \DateTime('2015-06-30'));
        $record->setPayer('Costco');
        $record->setReceiptDate(new \DateTime('2015-07-01'));
        $record->setPaymentMethod('Printed Check');
        $record->setBankAccountId('BA1234');
        $record->setDepositDate(new \DateTime('2015-07-04'));
        $record->setTransactionNo('transno');
        $record->setDescription('my desc');
        $record->setAttachmentsId('A1234');
        $record->setTransactionCurrency('USD');
        $record->setExchangeRateDate(new \DateTime('2015-07-04'));
        $record->setExchangeRateType('Intacct Daily Rate');
        $record->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $line1 = new OtherReceiptLineCreate();
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
        $this->expectExceptionMessage("CM Other Receipt must have at least 1 line");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new OtherReceiptCreate('unittest');
        $record->setTransactionDate(new \DateTime('2015-06-30'));
        $record->setPayer('Costco');
        $record->setReceiptDate(new \DateTime('2015-07-01'));
        $record->setPaymentMethod('Printed Check');
        $record->setUndepositedFundsGlAccountNo('1000');

        $record->writeXml($xml);
    }
}
