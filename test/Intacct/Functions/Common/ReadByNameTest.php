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

class ReadByNameTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Common\ReadByName::__construct
     * @covers Intacct\Functions\Common\ReadByName::setReturnFormat
     * @covers Intacct\Functions\Common\ReadByName::setNames
     * @covers Intacct\Functions\Common\ReadByName::getNamesForXml
     * @covers Intacct\Functions\Common\ReadByName::getFieldsForXml
     * @covers Intacct\Functions\Common\ReadByName::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readByName>
        <object>GLENTRY</object>
        <keys></keys>
        <fields>*</fields>
        <returnFormat>xml</returnFormat>
    </readByName>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readByName = new ReadByName([
            'object' => 'GLENTRY',
            'control_id' => 'unittest',
        ]);
        $readByName->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\ReadByName::__construct
     * @covers Intacct\Functions\Common\ReadByName::setReturnFormat
     * @covers Intacct\Functions\Common\ReadByName::setNames
     * @covers Intacct\Functions\Common\ReadByName::getNamesForXml
     * @covers Intacct\Functions\Common\ReadByName::getFieldsForXml
     * @covers Intacct\Functions\Common\ReadByName::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readByName>
        <object>GLENTRY</object>
        <keys>987</keys>
        <fields>TRX_AMOUNT,RECORDNO,BATCHNO</fields>
        <returnFormat>xml</returnFormat>
        <docparid>390FJ234MGF0-323F&amp;23T.</docparid>
    </readByName>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readByName = new ReadByName([
            'object' => 'GLENTRY',
            'control_id' => 'unittest',
            'names' => ['987'],
            'fields' => ['TRX_AMOUNT','RECORDNO','BATCHNO'],
            'doc_par_id' => '390FJ234MGF0-323F&23T.',
            'return_format' => 'xml',
        ]);
        $readByName->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\ReadByName::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        new ReadByName([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'return_format' => ''
        ]);
    }

    /**
     * @covers Intacct\Functions\Common\ReadByName::setNames
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage names count cannot exceed 100
     */
    public function testMaxNumberOfNames()
    {
        $names = new \SplFixedArray(101);

        new ReadByName([
            'object' => 'CLASS',
            'control_id' => 'unittest',
            'names' => $names->toArray(),
        ]);
    }
}