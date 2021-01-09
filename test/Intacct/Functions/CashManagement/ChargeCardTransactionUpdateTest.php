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
 * @coversDefaultClass \Intacct\Functions\CashManagement\ChargeCardTransactionUpdate
 */
class ChargeCardTransactionUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update_cctransaction key="1234" />
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ChargeCardTransactionUpdate('unittest');
        $record->setRecordNo(1234);

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update_cctransaction key="1234">
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
        <updateccpayitems>
            <updateccpayitem line_num="1">
                <paymentamount>76343.43</paymentamount>
            </updateccpayitem>
        </updateccpayitems>
    </update_cctransaction>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ChargeCardTransactionUpdate('unittest');
        $record->setRecordNo(1234);
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

        $line1 = new ChargeCardTransactionLineUpdate();
        $line1->setLineNo(1);
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
        $this->expectExceptionMessage("Record No is required for update");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ChargeCardTransactionUpdate('unittest');

        $record->writeXml($xml);
    }
}
