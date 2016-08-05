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

class ReadByQueryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::__construct
     * @covers Intacct\Functions\Common\ReadByQuery::setControlId
     * @covers Intacct\Functions\Common\ReadByQuery::getControlId
     * @covers Intacct\Functions\Common\ReadByQuery::setFields
     * @covers Intacct\Functions\Common\ReadByQuery::getFields
     * @covers Intacct\Functions\Common\ReadByQuery::setPageSize
     * @covers Intacct\Functions\Common\ReadByQuery::setReturnFormat
     * @covers Intacct\Functions\Common\ReadByQuery::setQuery
     * @covers Intacct\Functions\Common\ReadByQuery::setDocParId
     * @covers Intacct\Functions\Common\ReadByQuery::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readByQuery>
        <object>CLASS</object>
        <query>RECORDNO &lt; 2</query>
        <fields>*</fields>
        <pagesize>1000</pagesize>
        <returnFormat>xml</returnFormat>
    </readByQuery>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readByQuery = new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'query' => 'RECORDNO < 2',
        ]);
        $readByQuery->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::__construct
     * @covers Intacct\Functions\Common\ReadByQuery::setControlId
     * @covers Intacct\Functions\Common\ReadByQuery::getControlId
     * @covers Intacct\Functions\Common\ReadByQuery::setFields
     * @covers Intacct\Functions\Common\ReadByQuery::getFields
     * @covers Intacct\Functions\Common\ReadByQuery::setPageSize
     * @covers Intacct\Functions\Common\ReadByQuery::setReturnFormat
     * @covers Intacct\Functions\Common\ReadByQuery::setQuery
     * @covers Intacct\Functions\Common\ReadByQuery::setDocParId
     * @covers Intacct\Functions\Common\ReadByQuery::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readByQuery>
        <object>CLASS</object>
        <query/>
        <fields>RECORDNO</fields>
        <pagesize>100</pagesize>
        <returnFormat>xml</returnFormat>
        <docparid>255252235</docparid>
    </readByQuery>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readByQuery = new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'query' => '',
            'page_size' => 100,
            'return_format' => 'xml',
            'fields' => [
                'RECORDNO',
            ],
            'doc_par_id' => '255252235',
        ]);

        $readByQuery->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::setQuery
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage query must be a string
     */
    public function testQueryMissing()
    {
        new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
        ]);
    }

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size not valid int type
     */
    public function testStringForPageSize()
    {
        new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'query' => 'RECORDNO < 2',
            'page_size' => '5',
        ]);
    }

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size cannot be less than 1
     */
    public function testMinPageSize()
    {
        new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'query' => 'RECORDNO < 2',
            'page_size' => 0,
        ]);
    }

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::setPageSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage page_size cannot be greater than 1000
     */
    public function testMaxPageSize()
    {
        new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'query' => 'RECORDNO < 2',
            'page_size' => 1001,
        ]);
    }

    /**
     * @covers Intacct\Functions\Common\ReadByQuery::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        new ReadByQuery([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'query' => 'RECORDNO < 2',
            'page_size' => 100,
            'return_format' => ''
        ]);
    }
}
