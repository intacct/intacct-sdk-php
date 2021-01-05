<?php
/**
 * Copyright 2021 Sage Intacct, Inc.
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

/**
 * @coversDefaultClass \Intacct\Functions\Common\ReadRelated
 */
class ReadRelatedTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readRelated>
        <object>CUSTOM_OBJECT</object>
        <relation>CUSTOM_OBJECT_ITEM</relation>
        <keys/>
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

        $readRelated = new ReadRelated('unittest');
        $readRelated->setObjectName('CUSTOM_OBJECT');
        $readRelated->setRelationName('CUSTOM_OBJECT_ITEM');

        $readRelated->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readRelated>
        <object>CUSTOM_OBJECT</object>
        <relation>CUSTOM_OBJECT_ITEM</relation>
        <keys>KEY1,KEY2</keys>
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

        $readRelated = new ReadRelated('unittest');
        $readRelated->setObjectName('CUSTOM_OBJECT');
        $readRelated->setRelationName('CUSTOM_OBJECT_ITEM');
        $readRelated->setKeys(['KEY1','KEY2']);
        $readRelated->setFields(['FIELD1','FIELD2']);

        $readRelated->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoRelation(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Relation Name is required for read related");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $read = new ReadRelated('unittest');
        $read->setObjectName('CUSTOM_OBJECT');

        $read->writeXml($xml);
    }

    public function testMaxNumberOfKeys(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Keys count cannot exceed 100");

        $keys = new \SplFixedArray(101);

        $read = new ReadRelated('unittest');
        $read->setKeys($keys->toArray());
    }
}
