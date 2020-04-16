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

namespace Intacct\Tests\Functions\Common\QuerySelect;

use Intacct\Functions\Common\QuerySelect\SelectBuilder;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use TypeError;

/**
 * @coversDefaultClass \Intacct\Functions\Common\QuerySelect\SelectBuilder
 */
class SelectBuilderTest extends \PHPUnit\Framework\TestCase
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

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->getFields();

        foreach ( $fields as $field ) {
            $field->writeXML($xml);
        }

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException TypeError
     */
    public function testNullField()
    {
        ( new SelectBuilder() )->field(null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyField()
    {
        ( new SelectBuilder() )->field('');
    }

    public function testFields()
    {
        $fieldNameList = [ 'CUSTOMERID', 'TOTALDUE', 'WHENDUE', 'TOTALENTERED', 'TOTALDUE', 'RECORDNO' ];
        $fields = ( new SelectBuilder() )->fields($fieldNameList)
                                         ->getFields();

        $this->assertCount(count($fieldNameList), $fields);
    }

    /**
     * @expectedException TypeError
     */
    public function testNullFields()
    {
        ( new SelectBuilder() )->fields(null)
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields cannot be empty or null. Provide a list of fields for the builder.
     */
    public function testNullInFields()
    {
        ( new SelectBuilder() )->fields([ '', null ])
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields cannot be empty or null. Provide a list of fields for the builder.
     */
    public function testEmptyStringInFields()
    {
        ( new SelectBuilder() )->fields([ '' ])
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

        $fields = ( new SelectBuilder() )->avg('PRICE')
                                         ->getFields();

        foreach ( $fields as $field ) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    /**
     * @expectedException TypeError
     */
    public function testNullAvg()
    {
        ( new SelectBuilder() )->avg(null)
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for avg cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyAvg()
    {
        ( new SelectBuilder() )->avg('')
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

        $fields = ( new SelectBuilder() )->min('PRICE')
                                         ->getFields();

        foreach ( $fields as $field ) {
            $field->writeXML($xml);
        }

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException TypeError
     */
    public function testNullMin()
    {
        ( new SelectBuilder() )->min(null)
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for min cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyMin()
    {
        ( new SelectBuilder() )->min('')
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

        $fields = ( new SelectBuilder() )->max('PRICE')
                                         ->getFields();

        foreach ( $fields as $field ) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    /**
     * @expectedException TypeError
     */
    public function testNullMax()
    {
        ( new SelectBuilder() )->max(null)
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for max cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyMax()
    {
        ( new SelectBuilder() )->max('')
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

        $fields = ( new SelectBuilder() )->count('PRICE')
                                         ->getFields();

        foreach ( $fields as $field ) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    /**
     * @expectedException TypeError
     */
    public function testNullCount()
    {
        ( new SelectBuilder() )->avg(null)
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for count cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyCount()
    {
        ( new SelectBuilder() )->count('')
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

        $fields = ( new SelectBuilder() )->sum('PRICE')
                                         ->getFields();

        foreach ( $fields as $field ) {
            $field->writeXML($xml);
        }

        $x = $xml->flush();
        $this->assertXmlStringEqualsXmlString($expected, $x);
    }

    /**
     * @expectedException TypeError
     */
    public function testNullSum()
    {
        ( new SelectBuilder() )->sum(null)
                               ->getFields();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for sum cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptySum()
    {
        ( new SelectBuilder() )->sum('')
                               ->getFields();
    }
}