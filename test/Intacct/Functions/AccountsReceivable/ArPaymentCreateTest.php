<?php

/**
 * Copyright 2019 Sage Intacct, Inc.
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
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\ArPaymentCreate
 */
class ArPaymentCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_arpayment>
        <customerid>C0020</customerid>
        <paymentamount>1922.12</paymentamount>
        <datereceived>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </datereceived>
        <paymentmethod>Printed Check</paymentmethod>
    </create_arpayment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentCreate('unittest');
        $payment->setCustomerId('C0020');
        $payment->setTransactionPaymentAmount(1922.12);
        $payment->setReceivedDate(new \DateTime('2016-06-30'));
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Customer ID is required for create
     */
    public function testRequiredCustomerId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentCreate('unittest');
        //$payment->setCustomerId('C0020');
        $payment->setReceivedDate(new \DateTime('2016-06-30'));
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);

        $payment->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Received Date is required for create
     */
    public function testRequiredReceivedDate()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentCreate('unittest');
        $payment->setCustomerId('C0020');
        //$payment->setReceivedDate(new Date('2016-06-30'));
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);

        $payment->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Payment Method is required for create
     */
    public function testRequiredPaymentMethod()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ArPaymentCreate('unittest');
        $payment->setCustomerId('C0020');
        $payment->setReceivedDate(new \DateTime('2016-06-30'));
        //$payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);

        $payment->writeXml($xml);
    }
}
