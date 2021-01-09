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
 * @coversDefaultClass \Intacct\Functions\Common\ReadView
 */
class ReadViewTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readView>
        <view>TestBill Date Runtime</view>
        <pagesize>1000</pagesize>
        <returnFormat>xml</returnFormat>
    </readView>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readView = new ReadView('unittest');
        $readView->setViewName('TestBill Date Runtime');

        $readView->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readView>
        <view>TestBill Date Runtime</view>
        <pagesize>10</pagesize>
        <returnFormat>xml</returnFormat>
    </readView>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readView = new ReadView('unittest');
        $readView->setViewName('TestBill Date Runtime');
        $readView->setPageSize(10);

        $readView->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoView(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("View Name is required for read view");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readView = new ReadView('unittest');
        //$readView->setViewName('TestBill Date Runtime');

        $readView->writeXml($xml);
    }

    public function testMinPageSize(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Page Size cannot be less than 1");

        $readView = new ReadView('unittest');
        $readView->setPageSize(0);
    }

    public function testMaxPageSize(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Page Size cannot be greater than 1000");

        $readView = new ReadView('unittest');
        $readView->setPageSize(1001);
    }
}
