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

class ReadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\Common\Read::__construct
     * @covers Intacct\Functions\Common\Read::setReturnFormat
     * @covers Intacct\Functions\Common\Read::setKeys
     * @covers Intacct\Functions\Common\Read::getFieldsForXml
     * @covers Intacct\Functions\Common\Read::getKeysForXml
     * @covers Intacct\Functions\Common\Read::writeXml
     */
    public function testDefaultParams()
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
        $read->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\Read::__construct
     * @covers Intacct\Functions\Common\Read::setReturnFormat
     * @covers Intacct\Functions\Common\Read::setKeys
     * @covers Intacct\Functions\Common\Read::getFieldsForXml
     * @covers Intacct\Functions\Common\Read::getKeysForXml
     * @covers Intacct\Functions\Common\Read::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <read>
        <object>CLASS</object>
        <keys>Key1,Key2</keys>
        <fields>Field1,Field2</fields>
        <returnFormat>xml</returnFormat>
        <docparid>0293jgi823j4iof2w</docparid>
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
            'control_id' => 'unittest',
            'return_format' => 'xml',
            'fields' => [
                'Field1',
                'Field2',
            ],
            'keys' => [
                'Key1',
                'Key2',
            ],
            'doc_par_id' => '0293jgi823j4iof2w',

        ]);
        $read->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\Read::setReturnFormat
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
     * @covers Intacct\Functions\Common\Read::setReturnFormat
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
     * @covers Intacct\Functions\Common\Read::setKeys
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
     * @covers Intacct\Functions\Common\Read::setKeys
     * @covers Intacct\Functions\Common\Read::getKeysForXml
     */
    public function testGetKeysForXml()
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
        $read->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
