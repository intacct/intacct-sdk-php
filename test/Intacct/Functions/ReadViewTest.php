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

class ReadViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\ReadView::__construct
     * @covers Intacct\Functions\ReadView::setViewName
     * @covers Intacct\Functions\ReadView::setControlId
     * @covers Intacct\Functions\ReadView::getControlId
     * @covers Intacct\Functions\ReadView::setPageSize
     * @covers Intacct\Functions\ReadView::setReturnFormat
     * @covers Intacct\Functions\ReadView::getXml
     */
    public function testDefaultParams()
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

        $readView = new ReadView([
            'view' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
        ]);
        $readView->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\ReadView::__construct
     * @covers Intacct\Functions\ReadView::setViewName
     * @covers Intacct\Functions\ReadView::setControlId
     * @covers Intacct\Functions\ReadView::getControlId
     * @covers Intacct\Functions\ReadView::setPageSize
     * @covers Intacct\Functions\ReadView::setReturnFormat
     * @covers Intacct\Functions\ReadView::getXml
     */
    public function testParamOverrides()
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

        $readView = new ReadView([
            'view' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => 10,
            'return_format' => 'xml'
        ]);
        $readView->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\ReadView::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "view" key not supplied in params
     */
    public function testNoView()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new ReadView([
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadView::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size not valid int type
     */
    public function testInvalidPageSize()
    {
        new ReadView([
            'view' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => '200',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadView::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size cannot be less than 1
     */
    public function testMinPageSize()
    {
        new ReadView([
            'view' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => 0,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadView::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size cannot be greater than 1000
     */
    public function testMaxPageSize()
    {
        new ReadView([
            'view' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'page_size' => 1001,
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadView::setViewName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage view is not a valid string
     */
    public function testInvalidViewName()
    {
        new ReadView([
            'view' => 234234234,
            'control_id' => 'unittest',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadView::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        new ReadView([
            'view' => 'TestBill Date Runtime',
            'control_id' => 'unittest',
            'return_format' => ''
        ]);
    }
}
