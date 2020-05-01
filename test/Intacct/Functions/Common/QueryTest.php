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
use Intacct\Functions\Common\QueryFilter\AndOperator;
use Intacct\Functions\Common\QueryFilter\Filter;
use Intacct\Functions\Common\QueryFilter\OrOperator;
use Intacct\Functions\Common\QueryOrderBy\OrderBuilder;
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
     * @expectedExceptionMessage Field name for select cannot be empty or null. Provide Field name for select in array.
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

    public function testOrderBy()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>ARINVOICE</object>
        <orderby>
            <order>
                <field>TOTALDUE</field>
                <ascending/>
            </order>
            <order>
                <field>RECORDNO</field>
                <descending/>
            </order>
        </orderby>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'RECORDNO' ])
                                         ->getFields();

        $orderBy = ( new OrderBuilder() )->ascending('TOTALDUE')
                                         ->descending('RECORDNO')
                                         ->getOrders();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE')
                                          ->orderBy($orderBy);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Field name for orderBy cannot be empty or null. Provide orders for orderBy in array.
     */
    public function testEmptyOrderBy()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->field('CUSTOMERID')
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('CUSTOMER')
                                          ->orderBy([]);

        $query->writeXML($xml);
    }

    public function testFilter()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>ARINVOICE</object>
        <filter>
            <lessthanorequalto>
                <field>RECORDNO</field>
                <value>10</value>
            </lessthanorequalto>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'RECORDNO' ])
                                         ->getFields();

        $filter = ( new Filter('RECORDNO') )->lessthanorequalto('10');

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE')
                                          ->filter($filter);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * Test RECORDNO >= 1 && RECORDNO <= 100
     */
    public function testFilterAndCondition()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>ARINVOICE</object>
        <filter>
            <and>
                <greaterthanorequalto>
                    <field>RECORDNO</field>
                    <value>1</value>
                </greaterthanorequalto>
                <lessthanorequalto>
                    <field>RECORDNO</field>
                    <value>100</value>
                </lessthanorequalto>
            </and>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = new AndOperator([ ( new Filter('RECORDNO') )->greaterthanorequalto('1'),
                                    ( new Filter('RECORDNO') )->lessthanorequalto('100') ]);

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'RECORDNO' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE')
                                          ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * Test RECORDNO <= 10 || RECORDNO = 100 || RECORDNO = 1000 || RECORDNO = 10000
     */
    public function testFilterOrCondition()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>ARINVOICE</object>
        <filter>
            <or>
                <lessthanorequalto>
                    <field>RECORDNO</field>
                    <value>10</value>
                </lessthanorequalto>
                <equalto>
                    <field>RECORDNO</field>
                    <value>100</value>
                </equalto>
                <equalto>
                    <field>RECORDNO</field>
                    <value>1000</value>
                </equalto>
                <equalto>
                    <field>RECORDNO</field>
                    <value>10000</value>
                </equalto>
            </or>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = new OrOperator([ ( new Filter('RECORDNO') )->lessthanorequalto('10'),
                                   ( new Filter('RECORDNO') )->equalto('100'),
                                   ( new Filter('RECORDNO') )->equalto('1000'),
                                   ( new Filter('RECORDNO') )->equalto('10000') ]);

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'RECORDNO' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE')
                                          ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testFilterOrWithAndCondition()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>BATCHNO</field>
            <field>RECORDNO</field>
            <field>STATE</field>	
        </select>
        <object>GLBATCH</object>
        <filter>
            <or>
                <equalto>
                    <field>JOURNAL</field>
                    <value>APJ</value>
                </equalto>
                <and>
                    <greaterthanorequalto>
                        <field>BATCHNO</field>
                        <value>1</value>
                    </greaterthanorequalto>
                    <equalto>
                        <field>STATE</field>
                        <value>Posted</value>
                    </equalto>
                </and>
            </or>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $batchnoAndState = new AndOperator([ ( new Filter('BATCHNO') )->greaterthanorequalto('1'),
                                             ( new Filter('STATE') )->equalto('Posted') ]);

        $journal = ( new Filter('JOURNAL') )->equalto('APJ');

        $filter = new OrOperator([ $journal, $batchnoAndState ]);

        $fields = ( new SelectBuilder() )->fields([ 'BATCHNO', 'RECORDNO', 'STATE' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('GLBATCH')
                                          ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAlternateFilterOrWithAndCondition()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>BATCHNO</field>
            <field>RECORDNO</field>
            <field>STATE</field>	
        </select>
        <object>GLBATCH</object>
        <filter>
            <or>
                <equalto>
                    <field>JOURNAL</field>
                    <value>APJ</value>
                </equalto>
                <and>
                    <greaterthanorequalto>
                        <field>BATCHNO</field>
                        <value>1</value>
                    </greaterthanorequalto>
                    <equalto>
                        <field>STATE</field>
                        <value>Posted</value>
                    </equalto>
                </and>
            </or>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $andOperator = new AndOperator(null);
        $andOperator->addFilter(( new Filter('BATCHNO') )->greaterthanorequalto('1'))
                    ->addFilter(( new Filter('STATE') )->equalto('Posted'));

        $journal = ( new Filter('JOURNAL') )->equalto('APJ');

        $orOperator = new OrOperator(null);
        $orOperator->addFilter($journal)
                   ->addFilter($andOperator);

        $fields = ( new SelectBuilder() )->fields([ 'BATCHNO', 'RECORDNO', 'STATE' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('GLBATCH')
                                          ->filter($orOperator);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testThreeLevelFilter()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>BATCHNO</field>
            <field>RECORDNO</field>
            <field>STATE</field>	
        </select>
        <object>GLBATCH</object>
        <filter>
            <or>
                <and>
                    <equalto>
                        <field>JOURNAL</field>
                        <value>APJ</value>
                    </equalto>
                    <equalto>
                        <field>STATE</field>
                        <value>Posted</value>
                    </equalto>
                </and>
                <and>
                    <equalto>
                        <field>JOURNAL</field>
                        <value>RCPT</value>
                    </equalto>
                    <equalto>
                        <field>STATE</field>
                        <value>Posted</value>
                    </equalto>
                    <or>
                        <equalto>
                            <field>RECORDNO</field>
                            <value>168</value>
                        </equalto>
                        <equalto>
                            <field>RECORDNO</field>
                            <value>132</value>
                        </equalto>
                    </or>
                </and>
            </or>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $APJAndState = new AndOperator([ ( new Filter('JOURNAL') )->equalto('APJ'),
                                         ( new Filter('STATE') )->equalto('Posted') ]);

        $RECORDNOOR = new OrOperator([ ( new Filter('RECORDNO') )->equalto('168'),
                                       ( new Filter('RECORDNO') )->equalto('132') ]);

        $RCPTAndState = new AndOperator([ ( new Filter('JOURNAL') )->equalto('RCPT'),
                                          ( new Filter('STATE') )->equalto('Posted'),
                                          $RECORDNOOR ]);

        $filter = new OrOperator([ $APJAndState, $RCPTAndState ]);

        $fields = ( new SelectBuilder() )->fields([ 'BATCHNO', 'RECORDNO', 'STATE' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('GLBATCH')
                                          ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}