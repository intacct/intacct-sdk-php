<?php

/*
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

namespace Intacct\Xml\Request\Operation\Content;

use XMLWriter;
use InvalidArgumentException;

class ReadTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::__construct
     * @covers Intacct\Xml\Request\Operation\Content\Read::setReturnFormat
     * @covers Intacct\Xml\Request\Operation\Content\Read::getFields
     * @covers Intacct\Xml\Request\Operation\Content\Read::getKeys
     * @covers Intacct\Xml\Request\Operation\Content\Read::getXml
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="read">
    <read>
        <object>CLASS</object>
        <fields>*</fields>
        <keys></keys>
        <returnFormat>xml</returnFormat>
    </read>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $read = new Read([
            'object' => 'CLASS',
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object" key not supplied in params
     */
    public function testNoObject()
    {
        new Read([
            'keys' => [
                '5'
            ],
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testReturnFormatJson()
    {
        new Read([
            'object' => 'CLASS',
            'keys' => [
                '5'
            ],
            'return_format' => 'json',
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testReturnFormatCsv()
    {
        new Read([
            'object' => 'CLASS',
            'keys' => [
                '5'
            ],
            'return_format' => 'csv',
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::setKeys
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage keys count cannot exceed 100
     */
    public function testTooManyKeys()
    {
        $keys = [];
        for ($i = 1; $i <= 101; $i++) {
            $keys[] = $i;
        }

        new Read([
            'object' => 'CLASS',
            'keys' => $keys,
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::__construct
     * @covers Intacct\Xml\Request\Operation\Content\Read::setFields
     * @covers Intacct\Xml\Request\Operation\Content\Read::getFields
     */
    public function testGetFields()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="read">
    <read>
        <object>CLASS</object>
        <fields>CLASSID,NAME</fields>
        <keys></keys>
        <returnFormat>xml</returnFormat>
    </read>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $read = new Read([
            'object' => 'CLASS',
            'fields' => [
                'CLASSID',
                'NAME',
            ],
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::__construct
     * @covers Intacct\Xml\Request\Operation\Content\Read::setKeys
     * @covers Intacct\Xml\Request\Operation\Content\Read::getKeys
     */
    public function testGetKeys()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="read">
    <read>
        <object>CLASS</object>
        <fields>*</fields>
        <keys>5,6</keys>
        <returnFormat>xml</returnFormat>
    </read>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $read = new Read([
            'object' => 'CLASS',
            'keys' => [
                '5',
                '6',
            ],
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Read::__construct
     * @covers Intacct\Xml\Request\Operation\Content\Read::getXml
     */
    public function testSetDocParId()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="read">
    <read>
        <object>SODOCUMENT</object>
        <fields>*</fields>
        <keys>5,6</keys>
        <returnFormat>xml</returnFormat>
        <docparid>Sales Invoice</docparid>
    </read>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $read = new Read([
            'object' => 'SODOCUMENT',
            'keys' => [
                '5',
                '6',
            ],
            'doc_par_id' => 'Sales Invoice',
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

}
