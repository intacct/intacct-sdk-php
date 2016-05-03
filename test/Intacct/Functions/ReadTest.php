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

namespace Intacct\Functions;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ReadTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Read::__construct
     * @covers Intacct\Functions\Read::setReturnFormat
     * @covers Intacct\Functions\Read::getFields
     * @covers Intacct\Functions\Read::getKeys
     * @covers Intacct\Functions\Read::getXml
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <read>
        <object>CLASS</object>
        <keys></keys>
        <fields>*</fields>
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
            'control_id' => 'unittest'
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Read::__construct
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
     * @covers Intacct\Functions\Read::setReturnFormat
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
     * @covers Intacct\Functions\Read::setReturnFormat
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
     * @covers Intacct\Functions\Read::setKeys
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
     * @covers Intacct\Functions\Read::__construct
     * @covers Intacct\Functions\Read::setFields
     * @covers Intacct\Functions\Read::getFields
     */
    public function testGetFields()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <read>
        <object>CLASS</object>
        <keys></keys>
        <fields>CLASSID,NAME</fields>
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
            'control_id' => 'unittest'
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Read::__construct
     * @covers Intacct\Functions\Read::setKeys
     * @covers Intacct\Functions\Read::getKeys
     */
    public function testGetKeys()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <read>
        <object>CLASS</object>
        <keys>5,6</keys>
        <fields>*</fields>
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
            'control_id' => 'unittest'
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Read::__construct
     * @covers Intacct\Functions\Read::getXml
     */
    public function testSetDocParId()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <read>
        <object>SODOCUMENT</object>
        <keys>5,6</keys>
        <fields>*</fields>
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
            'control_id' => 'unittest'
        ]);
        $read->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

}
