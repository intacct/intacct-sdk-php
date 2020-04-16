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

namespace Intacct\Tests\Functions\Common;

use Intacct\Functions\Common\Query;
use Intacct\Functions\Common\QuerySelect\SelectBuilder;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query
 */
class QueryTest extends \PHPUnit\Framework\TestCase
{
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
        </select>
        <object>CUSTOMER</object>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('CUSTOMER');

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAllParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>CUSTOMER</object>
        <docparid>REPORT</docparid>
        <options>
            <caseinsensitive>true</caseinsensitive>
        </options>
        <pagesize>10</pagesize>
        <offset>5</offset>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('CUSTOMER')
                                          ->docparid('REPORT')
                                          ->caseinsensitive(true)
                                          ->pagesize(10)
                                          ->offset(5);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for select cannot be empty or null. Provide fields for select in array.
     */
    public function testEmptySelect()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->select([]);

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object Name is required for query; set through method from setter.
     */
    public function testNoFromObject()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields);

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Select fields are required for query; set through method select setter.
     */
    public function testNoSelectFields()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->from('CUSTOMER');

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Select fields are required for query; set through method select setter.
     */
    public function testMissingRequiredParams()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') );

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object name for setting from cannot be empty or null. Set object name using from
     *                           setter.
     */
    public function testEmptyStringFromObject()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('');

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage docparid cannot be empty. Set docparid with valid document identifier.
     */
    public function testNullDocparid()
    {
        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        ( new Query('unittest') )->select($fields)
                                 ->from('CUSTOMER')
                                 ->docparid(null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage docparid cannot be empty. Set docparid with valid document identifier.
     */
    public function testEmptyDocparid()
    {
        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        ( new Query('unittest') )->select($fields)
                                 ->from('CUSTOMER')
                                 ->docparid('');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage offset cannot be negative. Set offset to zero or greater than zero.
     */
    public function testNegativeOffset()
    {
        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        ( new Query('unittest') )->select($fields)
                                 ->from('CUSTOMER')
                                 ->offset(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage pagesize cannot be negative. Set pagesize greater than zero.
     */
    public function testNegativePageSize()
    {
        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->field('RECORDNO')
                                         ->getFields();

        ( new Query('unittest') )->select($fields)
                                 ->from('CUSTOMER')
                                 ->pagesize(-1);
    }

    public function testFields()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>TOTALDUE</field>
            <field>WHENDUE</field>
            <field>TOTALENTERED</field>
            <field>TOTALDUE</field>
            <field>RECORDNO</field>
        </select>
        <object>ARINVOICE</object>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'TOTALDUE', 'WHENDUE', 'TOTALENTERED', 'TOTALDUE',
                                                    'RECORDNO' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE');

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAggregateFunctions()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <avg>TOTALDUE</avg>
            <min>WHENDUE</min>
            <max>TOTALENTERED</max>
            <sum>TOTALDUE</sum>
            <count>RECORDNO</count>
        </select>
        <object>ARINVOICE</object>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->avg('TOTALDUE')
                                         ->min('WHENDUE')
                                         ->max('TOTALENTERED')
                                         ->sum('TOTALDUE')
                                         ->count('RECORDNO')
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE');

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}