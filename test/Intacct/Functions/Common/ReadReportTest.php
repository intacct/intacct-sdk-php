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

/**
 * @coversDefaultClass \Intacct\Functions\Common\ReadReport
 */
class ReadReportTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readReport>
        <report>TestBill Date Runtime</report>
        <waitTime>0</waitTime>
        <pagesize>1000</pagesize>
        <returnFormat>xml</returnFormat>
    </readReport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');

        $readReport->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readReport>
        <report>TestBill Date Runtime</report>
        <waitTime>15</waitTime>
        <pagesize>200</pagesize>
        <returnFormat>xml</returnFormat>
        <listSeparator>,</listSeparator>
    </readReport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setPageSize(200);
        $readReport->setWaitTime(15);
        $readReport->setListSeparator(',');

        $readReport->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoReport(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Report Name is required for read report");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        //$readReport->setReportName('TestBill Date Runtime');

        $readReport->writeXml($xml);
    }

    public function testMinPageSize(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Page Size cannot be less than 1");

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setPageSize(0);
    }

    public function testMaxPageSize(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Page Size cannot be greater than 1000");

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setPageSize(1001);
    }

    public function testMinWaitTime(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Wait Time cannot be less than 0");

        $readReport = new ReadReport('unittest');
        $readReport->setWaitTime(-1);
    }

    public function testMaxWaitTime(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Wait Time cannot be greater than 30");

        $readReport = new ReadReport('unittest');
        $readReport->setWaitTime(31);
    }

    public function testReturnDef(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readReport returnDef="true">
        <report>TestBill Date Runtime</report>
    </readReport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setReturnDef(true);

        $readReport->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testComplexArguments(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readReport>
        <report>TestBill Date Runtime</report>
        <arguments>
            <APBILL.TEST_DATE>
                <FROM_DATE>1/1/2014</FROM_DATE>
                <TO_DATE>12/31/2016</TO_DATE>
            </APBILL.TEST_DATE>
        </arguments>
        <waitTime>0</waitTime>
        <pagesize>1000</pagesize>
        <returnFormat>xml</returnFormat>
    </readReport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setArguments([
            'APBILL.TEST_DATE' => [
                'FROM_DATE' => '1/1/2014',
                'TO_DATE' => '12/31/2016'
            ]
        ]);

        $readReport->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testSimpleArguments(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readReport>
        <report>TestBill Date Runtime</report>
        <arguments>
            <REPORTINGPERIOD>Current Year</REPORTINGPERIOD>
        </arguments>
        <waitTime>0</waitTime>
        <pagesize>1000</pagesize>
        <returnFormat>xml</returnFormat>
    </readReport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setArguments([
            'REPORTINGPERIOD' => 'Current Year'
        ]);

        $readReport->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
