<?php
/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Functions;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ReadReportTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\ReadReport::__construct
     * @covers Intacct\Functions\ReadReport::setControlId
     * @covers Intacct\Functions\ReadReport::getControlId
     * @covers Intacct\Functions\ReadReport::setReportName
     * @covers Intacct\Functions\ReadReport::setListSeparator
     * @covers Intacct\Functions\ReadReport::getListSeparator
     * @covers Intacct\Functions\ReadReport::setReturnDef
     * @covers Intacct\Functions\ReadReport::setArguments
     * @covers Intacct\Functions\ReadReport::setPageSize
     * @covers Intacct\Functions\ReadReport::setReturnFormat
     * @covers Intacct\Functions\ReadReport::getXml
     */
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

        $readReport = new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
        ]);
        $readReport->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\ReadReport::__construct
     * @covers Intacct\Functions\ReadReport::setReportName
     * @covers Intacct\Functions\ReadReport::setControlId
     * @covers Intacct\Functions\ReadReport::getControlId
     * @covers Intacct\Functions\ReadReport::setPageSize
     * @covers Intacct\Functions\ReadReport::setReturnFormat
     * @covers Intacct\Functions\ReadReport::setWaitTime
     * @covers Intacct\Functions\ReadReport::setListSeparator
     * @covers Intacct\Functions\ReadReport::getListSeparator
     * @covers Intacct\Functions\ReadReport::getXml
     */
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

        $readReport = new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => 200,
            'return_format' => 'xml',
            'wait_time' => 15,
            'list_separator' => ',',
        ]);
        $readReport->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\ReadReport::setReportName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage report must be a string
     */
    public function testInvalidReport()
    {
        new ReadReport([
            'control_id' => 'unittest',
            'report' => 43645346347124757
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "report" key not supplied in params
     */
    public function testNoReport()
    {
        new ReadReport([
            'control_id' => 'unittest',
        ]);
    }


    /**
     * @covers Intacct\Functions\ReadReport::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size not valid int type
     */
    public function testInvalidPageSize()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => '200',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size cannot be less than 1
     */
    public function testMinPageSize()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => 0,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size cannot be greater than 1000
     */
    public function testMaxPageSize()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => 1001,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::setWaitTime
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage wait_time not valid int type
     */
    public function testInvalidWaitTime()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'wait_time' => '1',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::setWaitTime
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage wait_time cannot be less than 0
     */
    public function testMinWaitTime()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'wait_time' => -1,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::setWaitTime
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage wait_time cannot be greater than 30
     */
    public function testMaxWaitTime()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'wait_time' => 31,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'return_format' => ''
        ]);
    }


    /**
     * @covers Intacct\Functions\ReadReport::setListSeparator
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage list_separator must be a string
     */
    public function testInvalidListSeparator()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'list_separator' => null,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadReport::__construct
     * @covers Intacct\Functions\ReadReport::setControlId
     * @covers Intacct\Functions\ReadReport::setReportName
     * @covers Intacct\Functions\ReadReport::setReturnDef
     * @covers Intacct\Functions\ReadReport::getReturnDef
     * @covers Intacct\Functions\ReadReport::getXml
     */
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

        $readReport = new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'return_def' => true,
        ]);
        $readReport->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\ReadReport::setReturnDef
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_def must be a bool
     */
    public function testInvalidReturnDef()
    {
        new ReadReport([
            'report' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'return_def' => null,
        ]);
    }
}