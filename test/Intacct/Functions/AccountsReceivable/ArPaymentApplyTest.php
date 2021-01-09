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
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\ArPaymentApply
 */
class ArPaymentApplyTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <apply_arpayment>
        <arpaymentkey>1234</arpaymentkey>
        <paymentdate>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
    </apply_arpayment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentApply('unittest');
        $payment->setRecordNo(1234);
        $payment->setReceivedDate(new \DateTime('2016-06-30'));

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredRecordNo()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Record No is required for apply");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentApply('unittest');
        //$payment->setRecordNo(1234);
        $payment->setReceivedDate(new \DateTime('2016-06-30'));

        $payment->writeXml($xml);
    }

    public function testRequiredCustomerId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Received Date is required for apply");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentApply('unittest');
        $payment->setRecordNo(1234);
        //$payment->setReceivedDate(new \DateTime('2016-06-30'));

        $payment->writeXml($xml);
    }
}
