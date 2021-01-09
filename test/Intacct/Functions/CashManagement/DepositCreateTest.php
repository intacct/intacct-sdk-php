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
 * @coversDefaultClass \Intacct\Functions\CashManagement\DepositCreate
 */
class DepositCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <record_deposit>
        <bankaccountid>BA1145</bankaccountid>
        <depositdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </depositdate>
        <depositid>Deposit Slip 2015-06-30</depositid>
        <receiptkeys>
            <receiptkey>1234</receiptkey>
        </receiptkeys>
    </record_deposit>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $deposit = new DepositCreate('unittest');
        $deposit->setBankAccountId('BA1145');
        $deposit->setDepositDate(new \DateTime('2015-06-30'));
        $deposit->setDepositSlipId('Deposit Slip 2015-06-30');
        $deposit->setTransactionKeysToDeposit([
            1234,
        ]);

        $deposit->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <record_deposit>
        <bankaccountid>BA1145</bankaccountid>
        <depositdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </depositdate>
        <depositid>Deposit Slip 2015-06-30</depositid>
        <receiptkeys>
            <receiptkey>1234</receiptkey>
        </receiptkeys>
        <description>Desc</description>
        <supdocid>AT111</supdocid>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
    </record_deposit>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $deposit = new DepositCreate('unittest');
        $deposit->setBankAccountId('BA1145');
        $deposit->setDepositDate(new \DateTime('2015-06-30'));
        $deposit->setDepositSlipId('Deposit Slip 2015-06-30');
        $deposit->setDescription('Desc');
        $deposit->setAttachmentsId('AT111');
        $deposit->setTransactionKeysToDeposit([
            1234,
        ]);
        $deposit->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $deposit->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingDepositEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("CM Deposit must have at least 1 transaction key to deposit");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $deposit = new DepositCreate('unittest');
        $deposit->setBankAccountId('BA1145');
        $deposit->setDepositDate(new \DateTime('2015-06-30'));
        $deposit->setDepositSlipId('Deposit Slip 2015-06-30');

        $deposit->writeXml($xml);
    }
}