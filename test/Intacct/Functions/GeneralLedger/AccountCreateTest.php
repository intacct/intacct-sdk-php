<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\GeneralLedger\AccountCreate
 */
class AccountCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <GLACCOUNT>
            <ACCOUNTNO>1010</ACCOUNTNO>
            <TITLE>hello world</TITLE>
            <ACCOUNTTYPE>balancesheet</ACCOUNTTYPE>
            <NORMALBALANCE>debit</NORMALBALANCE>
            <CLOSINGTYPE>non-closing account</CLOSINGTYPE>
        </GLACCOUNT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $account = new AccountCreate('unittest');
        $account->setAccountNo('1010');
        $account->setTitle('hello world');
        $account->setAccountType('balancesheet');
        $account->setNormalBalance('debit');
        $account->setClosingType('non-closing account');

        $account->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Account No is required for create
     */
    public function testRequiredAccountNo()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $account = new AccountCreate('unittest');
        //$account->setAccountNo('1010');
        $account->setTitle('hello world');
        $account->setAccountType('balancesheet');
        $account->setNormalBalance('debit');
        $account->setClosingType('non-closing account');

        $account->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Title is required for create
     */
    public function testRequiredTitle()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $account = new AccountCreate('unittest');
        $account->setAccountNo('1010');
        //$account->setTitle('hello world');
        $account->setAccountType('balancesheet');
        $account->setNormalBalance('debit');
        $account->setClosingType('non-closing account');

        $account->writeXml($xml);
    }
}
