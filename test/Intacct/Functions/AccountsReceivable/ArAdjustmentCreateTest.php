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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\ArAdjustmentCreate
 */
class ArAdjustmentCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
        <customerid>CUSTOMER1</customerid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <aradjustmentitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new ArAdjustmentCreate('unittest');
        $arAdjustment->setCustomerId('CUSTOMER1');
        $arAdjustment->setTransactionDate(new \DateTime('2015-06-30'));

        $line1 = new ArAdjustmentLineCreate();
        $line1->setTransactionAmount(76343.43);

        $arAdjustment->setLines([
            $line1,
        ]);

        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
        <customerid>CUSTOMER1</customerid>
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
        <batchkey>20323</batchkey>
        <adjustmentno>234235</adjustmentno>
        <action>Submit</action>
        <invoiceno>234</invoiceno>
        <description>Some description</description>
        <externalid>20394</externalid>
        <basecurr>USD</basecurr>
        <currency>USD</currency>
        <exchratedate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <nogl>false</nogl>
        <aradjustmentitems>
            <lineitem>
                <glaccountno></glaccountno>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new ArAdjustmentCreate('unittest');
        $arAdjustment->setCustomerId('CUSTOMER1');
        $arAdjustment->setTransactionDate(new \DateTime('2015-06-30'));
        $arAdjustment->setGlPostingDate(new \DateTime('2015-06-30'));
        $arAdjustment->setSummaryRecordNo('20323');
        $arAdjustment->setAdjustmentNumber('234235');
        $arAdjustment->setAction('Submit');
        $arAdjustment->setInvoiceNumber('234');
        $arAdjustment->setDescription('Some description');
        $arAdjustment->setExternalId('20394');
        $arAdjustment->setBaseCurrency('USD');
        $arAdjustment->setTransactionCurrency('USD');
        $arAdjustment->setExchangeRateDate(new \DateTime('2015-06-30'));
        $arAdjustment->setExchangeRateType('Intacct Daily Rate');
        $arAdjustment->setDoNotPostToGL(false);

        $line1 = new ArAdjustmentLineCreate();
        $line1->setTransactionAmount(76343.43);

        $arAdjustment->setLines([
            $line1,
        ]);

        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingAdjustmentEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("AR Adjustment must have at least 1 line");
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new ArAdjustmentCreate('unittest');
        $arAdjustment->setCustomerId('CUSTOMER1');
        $arAdjustment->setTransactionDate(new \DateTime('2015-06-30'));

        $arAdjustment->writeXml($xml);
    }
}
