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

class ReadRelatedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setReturnFormat
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @covers Intacct\Functions\ReadRelated::setRelation
     * @covers Intacct\Functions\ReadRelated::setKeys
     * @covers Intacct\Functions\ReadRelated::getKeys
     * @covers Intacct\Functions\ReadRelated::setFields
     * @covers Intacct\Functions\ReadRelated::getFields
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::getControlId
     * @covers Intacct\Functions\ReadRelated::getXml
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readRelated>
        <object>CUSTOM_OBJECT</object>
        <relation>CUSTOM_OBJECT_ITEM</relation>
        <keys/>
        <fields>FIELD1,FIELD2</fields>
        <returnFormat>xml</returnFormat>
    </readRelated>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readRelated = new ReadRelated([
            'object' => 'CUSTOM_OBJECT',
            'control_id' => 'unittest',
            'relation' => 'CUSTOM_OBJECT_ITEM',
            'keys' => [],
            'fields' => ['FIELD1','FIELD2'],
            'return_format' => 'xml',
        ]);
        $readRelated->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object" key not supplied in params
     */
    public function testNoObject()
    {
        new ReadRelated([
            'control_id' => 'unittest',
            'relation' => 'CUSTOM_OBJECT_ITEM',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @covers Intacct\Functions\ReadRelated::setRelation
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage object must be a string
     */
    public function testInvalidObject()
    {
        new ReadRelated([
            'control_id' => 'unittest',
            'object' => 9,
            'relation' => 'CUSTOM_OBJECT_ITEM',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "relation" key not supplied in params
     */
    public function testNoRelation()
    {
        new ReadRelated([
            'control_id' => 'unittest',
            'object' => 'CUSTOM_OBJECT',
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @covers Intacct\Functions\ReadRelated::setRelation
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage relation must be a string
     */
    public function testInvalidRelation()
    {
        new ReadRelated([
            'control_id' => 'unittest',
            'object' => 'CUSTOM_OBJECT',
            'relation' => ['CUSTOM_OBJECT_ITEM'],
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @covers Intacct\Functions\ReadRelated::setRelation
     * @covers Intacct\Functions\ReadRelated::setReturnFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage return_format is not a valid format
     */
    public function testInvalidReturnFormat()
    {
        new ReadRelated([
            'object' => 'CUSTOM_OBJECT',
            'relation' => 'CUSTOM_OBJECT_ITEM',
            'control_id' => 'unittest',
            'return_format' => ''
        ]);
    }

    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @covers Intacct\Functions\ReadRelated::setRelation
     * @covers Intacct\Functions\ReadRelated::setFields
     * @covers Intacct\Functions\ReadRelated::setKeys
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage keys count cannot exceed 100
     */
    public function testMaxNumberOfKeys()
    {
        $keys = new \SplFixedArray(101);

        new ReadRelated([
            'object' => 'CUSTOM_OBJECT',
            'relation' => 'CUSTOM_OBJECT_ITEM',
            'control_id' => 'unittest',
            'fields' => ['FIELD1','FIELD2'],
            'keys' => $keys->toArray(),
        ]);
    }


    /**
     * @covers Intacct\Functions\ReadRelated::__construct
     * @covers Intacct\Functions\ReadRelated::setControlId
     * @covers Intacct\Functions\ReadRelated::setObjectName
     * @covers Intacct\Functions\ReadRelated::setRelation
     * @covers Intacct\Functions\ReadRelated::setFields
     * @covers Intacct\Functions\ReadRelated::getFields
     * @covers Intacct\Functions\ReadRelated::setKeys
     * @covers Intacct\Functions\ReadRelated::getKeys
     */
    public function testNoFieldsGiven()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readRelated>
        <object>CUSTOM_OBJECT</object>
        <relation>CUSTOM_OBJECT_ITEM</relation>
        <keys>KEY1,KEY2</keys>
        <fields>*</fields>
        <returnFormat>xml</returnFormat>
    </readRelated>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readRelated = new ReadRelated([
            'object' => 'CUSTOM_OBJECT',
            'relation' => 'CUSTOM_OBJECT_ITEM',
            'control_id' => 'unittest',
            'keys' => ['KEY1','KEY2'],
        ]);

        $readRelated->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}