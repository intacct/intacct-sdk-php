<?php
/**
 * Copyright 2016 Intacct Corporation.
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
 * @coversDefaultClass \Intacct\Functions\Common\ReadReport
 */
class ReadReportTest extends \PHPUnit_Framework_TestCase
{

    public function testDefaultParams()
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

    public function testParamOverrides()
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
        $readReport->setReturnFormat('xml');
        $readReport->setWaitTime(15);
        $readReport->setListSeparator(',');

        $readReport->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Report Name must be a string
     */
    public function testInvalidReport()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setReportName(43645346347124757);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Report Name is required for read report
     */
    public function testNoReport()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readReport = new ReadReport('unittest');
        //$readReport->setReportName('TestBill Date Runtime');

        $readReport->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page Size not valid int type
     */
    public function testInvalidPageSize()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setPageSize('200');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page Size cannot be less than 1
     */
    public function testMinPageSize()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setPageSize(0);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page Size cannot be greater than 1000
     */
    public function testMaxPageSize()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setReportName('TestBill Date Runtime');
        $readReport->setPageSize(1001);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Wait Time not valid int type
     */
    public function testInvalidWaitTime()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setWaitTime('1');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Wait Time cannot be less than 0
     */
    public function testMinWaitTime()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setWaitTime(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Wait Time cannot be greater than 30
     */
    public function testMaxWaitTime()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setWaitTime(31);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Return Format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setReturnFormat('bad');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage List Separator must be a string
     */
    public function testInvalidListSeparator()
    {
        $readReport = new ReadReport('unittest');
        $readReport->setListSeparator(true);
    }

    public function testReturnDef()
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

    public function testComplexArguments()
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

    public function testSimpleArguments()
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
