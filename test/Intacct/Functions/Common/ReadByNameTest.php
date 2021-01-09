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

namespace Intacct\Functions\Common;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\ReadByName
 */
class ReadByNameTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readByName>
        <object>GLENTRY</object>
        <keys></keys>
        <fields>*</fields>
        <returnFormat>xml</returnFormat>
    </readByName>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readByName = new ReadByName('unittest');
        $readByName->setObjectName('GLENTRY');

        $readByName->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readByName>
        <object>GLENTRY</object>
        <keys>987</keys>
        <fields>TRX_AMOUNT,RECORDNO,BATCHNO</fields>
        <returnFormat>xml</returnFormat>
        <docparid>Sales Invoice</docparid>
    </readByName>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readByName = new ReadByName('unittest');
        $readByName->setObjectName('GLENTRY');
        $readByName->setNames(['987']);
        $readByName->setFields(['TRX_AMOUNT','RECORDNO','BATCHNO']);
        $readByName->setDocParId('Sales Invoice');

        $readByName->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMaxNumberOfNames(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Names count cannot exceed 100");

        $names = new \SplFixedArray(101);

        $readByName = new ReadByName('unittest');
        $readByName->setNames($names->toArray());
    }
}
