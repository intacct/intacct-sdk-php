<?php
/**
 * Copyright 2017 Intacct Corporation.
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
class ReadViewTest extends \PHPUnit_Framework_TestCase
{

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

        $readView = new ReadView('unittest');
        $readView->setViewName('TestBill Date Runtime');

        $readView->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

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

        $readView = new ReadView('unittest');
        $readView->setViewName('TestBill Date Runtime');
        $readView->setPageSize(10);
        $readView->setReturnFormat('xml');

        $readView->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage View Name is required for read view
     */
    public function testNoView()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readView = new ReadView('unittest');
        //$readView->setViewName('TestBill Date Runtime');

        $readView->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page Size not valid int type
     */
    public function testInvalidPageSize()
    {
        $readView = new ReadView('unittest');
        $readView->setPageSize('200');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page Size cannot be less than 1
     */
    public function testMinPageSize()
    {
        $readView = new ReadView('unittest');
        $readView->setPageSize(0);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Page Size cannot be greater than 1000
     */
    public function testMaxPageSize()
    {
        $readView = new ReadView('unittest');
        $readView->setPageSize(1001);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage View Name is not a valid string
     */
    public function testInvalidViewName()
    {
        $readView = new ReadView('unittest');
        $readView->setViewName(23232323);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Return Format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        $readView = new ReadView('unittest');
        $readView->setReturnFormat('');
    }
}
