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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsPayable\ApAccountLabelCreate
 */
class ApAccountLabelCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APACCOUNTLABEL>
            <ACCOUNTLABEL>expense</ACCOUNTLABEL>
            <DESCRIPTION>hello world</DESCRIPTION>
            <GLACCOUNTNO>6500</GLACCOUNTNO>
        </APACCOUNTLABEL>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $label = new ApAccountLabelCreate('unittest');
        $label->setAccountLabel('expense');
        $label->setDescription('hello world');
        $label->setGlAccountNo('6500');

        $label->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredAccountLabel(): void
    {
        $this->expectExceptionMessage("Account Label is required for create");
        $this->expectException(InvalidArgumentException::class);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $label = new ApAccountLabelCreate('unittest');
        //$label->setAccountLabel('expense');
        $label->setDescription('hello world');
        $label->setGlAccountNo('6500');

        $label->writeXml($xml);
    }

    public function testRequiredDescription(): void
    {
        $this->expectExceptionMessage("Description is required for create");
        $this->expectException(InvalidArgumentException::class);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $label = new ApAccountLabelCreate('unittest');
        $label->setAccountLabel('expense');
        //$label->setDescription('hello world');
        $label->setGlAccountNo('6500');

        $label->writeXml($xml);
    }

    public function testRequiredGlAccount(): void
    {
        $this->expectExceptionMessage("GL Account is required for create");
        $this->expectException(InvalidArgumentException::class);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $label = new ApAccountLabelCreate('unittest');
        $label->setAccountLabel('expense');
        $label->setDescription('hello world');
        //$label->setGlAccountNo('6500');

        $label->writeXml($xml);
    }
}
