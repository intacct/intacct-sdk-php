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

namespace Intacct\Functions\AccountsReceivable\PaymentServices;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\PaymentServices\CustomerChargeCardCreate
 */
class CustomerChargeCardCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_customerchargecard>
        <customerid>C1234</customerid>
        <cardnum>1111222233334444</cardnum>
        <cardtype>Visa</cardtype>
        <exp_month>June</exp_month>
        <exp_year>1999</exp_year>
        <mailaddress/>
    </create_customerchargecard>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new CustomerChargeCardCreate('unittest');
        $obj->setCustomerId('C1234');
        $obj->setCardNumber('1111222233334444');
        $obj->setCardType($obj::CARD_TYPE_VISA);
        $obj->setExpirationMonth('June');
        $obj->setExpirationYear('1999');

        $obj->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredCustomerId(): void
    {
        $this->expectExceptionMessage("Customer ID is required for create");
        $this->expectException(InvalidArgumentException::class);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new CustomerChargeCardCreate('unittest');
        //$obj->setCustomerId('C1234');
        $obj->setCardNumber('1111222233334444');
        $obj->setCardType($obj::CARD_TYPE_VISA);
        $obj->setExpirationMonth('June');
        $obj->setExpirationYear('1999');

        $obj->writeXml($xml);
    }

    public function testRequiredCardNum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Card Number is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new CustomerChargeCardCreate('unittest');
        $obj->setCustomerId('C1234');
        //$obj->setCardNumber('1111222233334444');
        $obj->setCardType($obj::CARD_TYPE_VISA);
        $obj->setExpirationMonth('June');
        $obj->setExpirationYear('1999');

        $obj->writeXml($xml);
    }

    public function testRequiredCardType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Card Type is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new CustomerChargeCardCreate('unittest');
        $obj->setCustomerId('C1234');
        $obj->setCardNumber('1111222233334444');
        //$obj->setCardType($obj::CARD_TYPE_VISA);
        $obj->setExpirationMonth('June');
        $obj->setExpirationYear('1999');

        $obj->writeXml($xml);
    }

    public function testRequiredExpMonth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expiration Month is required for create");
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new CustomerChargeCardCreate('unittest');
        $obj->setCustomerId('C1234');
        $obj->setCardNumber('1111222233334444');
        $obj->setCardType($obj::CARD_TYPE_VISA);
        //$obj->setExpirationMonth('June');
        $obj->setExpirationYear('1999');

        $obj->writeXml($xml);
    }

    public function testRequiredExpYear(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expiration Year is required for create");
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new CustomerChargeCardCreate('unittest');
        $obj->setCustomerId('C1234');
        $obj->setCardNumber('1111222233334444');
        $obj->setCardType($obj::CARD_TYPE_VISA);
        $obj->setExpirationMonth('June');
        //$obj->setExpirationYear('1999');

        $obj->writeXml($xml);
    }
}
