<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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

namespace Intacct\Functions\Common\NewQuery\QuerySelect;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @coversDefaultClass \Intacct\Functions\Common\NewQuery\QuerySelect\SelectBuilder
 */
class SelectBuilderTest extends TestCase
{

    public function testField()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<field>CUSTOMERID</field>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->getFields();

        foreach ($fields as $field) {
            $field->writeXML($xml);
        }

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNullField()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->field(null);
    }

    public function testEmptyField()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field name cannot be empty or null. Provide a field name for the builder.");

        (new SelectBuilder())->field('');
    }

    public function testFields()
    {
        $fieldNameList = ['CUSTOMERID', 'TOTALDUE', 'WHENDUE', 'TOTALENTERED', 'TOTALDUE', 'RECORDNO'];
        $fields = (new SelectBuilder())->fields($fieldNameList)
            ->getFields();

        $this->assertCount(count($fieldNameList), $fields);
    }

    public function testNullFields()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->fields(null)
            ->getFields();
    }

    public function testNullInFields()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field name cannot be empty or null. Provide a field name for the builder.");

        (new SelectBuilder())->fields(['', null])
            ->getFields();
    }

    public function testEmptyStringInFields()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field name cannot be empty or null. Provide a field name for the builder.");

        (new SelectBuilder())->fields([''])
            ->getFields();
    }

    public function testAvg()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<avg>PRICE</avg>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->avg('PRICE')
            ->getFields();

        foreach ($fields as $field) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    public function testNullAvg()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->avg(null)
            ->getFields();
    }

    public function testEmptyAvg()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for avg cannot be empty or null. Provide a field name for the builder."
        );

        (new SelectBuilder())->avg('')
            ->getFields();
    }

    public function testMin()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<min>PRICE</min>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->min('PRICE')
            ->getFields();

        foreach ($fields as $field) {
            $field->writeXML($xml);
        }

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNullMin()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->min(null)
            ->getFields();
    }

    public function testEmptyMin()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for min cannot be empty or null. Provide a field name for the builder."
        );

        (new SelectBuilder())->min('')
            ->getFields();
    }

    public function testMax()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<max>PRICE</max>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->max('PRICE')
            ->getFields();

        foreach ($fields as $field) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    public function testNullMax()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->max(null)
            ->getFields();
    }

    public function testEmptyMax()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for max cannot be empty or null. Provide a field name for the builder.");

        (new SelectBuilder())->max('')
            ->getFields();
    }

    public function testCount()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<count>PRICE</count>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->count('PRICE')
            ->getFields();

        foreach ($fields as $field) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    public function testNullCount()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->avg(null)
            ->getFields();
    }

    public function testEmptyCount()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for count cannot be empty or null. Provide a field name for the builder.");

        (new SelectBuilder())->count('')
            ->getFields();
    }

    public function testSum()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sum>PRICE</sum>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->sum('PRICE')
            ->getFields();

        foreach ($fields as $field) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    public function testNullSum()
    {
        $this->expectException(TypeError::class);

        (new SelectBuilder())->sum(null)
            ->getFields();
    }

    public function testEmptySum()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for sum cannot be empty or null. Provide a field name for the builder.");

        (new SelectBuilder())->sum('')
            ->getFields();
    }

    public function testInvalidFunction()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("FOO function doesn't exist.");

        (new SelectFunctionFactory())->create('FOO','FOO');
    }
}