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

namespace Intacct\Functions\Common\NewQuery;

use Intacct\Functions\Common\NewQuery\QueryFilter\AndOperator;
use Intacct\Functions\Common\NewQuery\QueryFilter\Filter;
use Intacct\Functions\Common\NewQuery\QueryFilter\OrOperator;
use Intacct\Functions\Common\NewQuery\QueryOrderBy\OrderBuilder;
use Intacct\Functions\Common\NewQuery\QuerySelect\SelectBuilder;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Intacct\Functions\Common\NewQuery\Query
 */
class QueryTest extends TestCase
{

    public function testDefaultParams(): void
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

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('CUSTOMER');

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAllParams(): void
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
            <showprivate>true</showprivate>
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

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('CUSTOMER')
            ->docParId('REPORT')
            ->caseInsensitive(true)
            ->showPrivate(true)
            ->pageSize(10)
            ->offset(5);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testEmptySelect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for select cannot be empty or null. Provide Field name for select in array."
        );

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = (new Query('unittest'))->select([]);

        $query->writeXML($xml);
    }

    public function testNoFromObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Object Name is required for query; set through method from setter.");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        $query = (new Query('unittest'))->select($fields);

        $query->writeXML($xml);
    }

    public function testNoSelectFields(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Select fields are required for query; set through method select setter.");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = (new Query('unittest'))->from('CUSTOMER');

        $query->writeXML($xml);
    }

    public function testMissingRequiredParams(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Select fields are required for query; set through method select setter.");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = (new Query('unittest'));

        $query->writeXML($xml);
    }

    public function testEmptyStringFromObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Object name for setting from cannot be empty or null. Set object name using from setter."
        );

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('');

        $query->writeXML($xml);
    }

    public function testNullDocparid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("docParId cannot be empty. Set docParId with valid document identifier.");

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        (new Query('unittest'))->select($fields)
            ->from('CUSTOMER')
            ->docParId(null);
    }

    public function testEmptyDocparid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("docParId cannot be empty. Set docParId with valid document identifier.");

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        (new Query('unittest'))->select($fields)
            ->from('CUSTOMER')
            ->docParId('');
    }

    public function testNegativeOffset(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("offset cannot be negative. Set offset to zero or greater than zero.");

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        (new Query('unittest'))->select($fields)
            ->from('CUSTOMER')
            ->offset(-1);
    }

    public function testNegativePageSize(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("pageSize cannot be negative. Set pageSize greater than zero.");

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->field('RECORDNO')
            ->getFields();

        (new Query('unittest'))->select($fields)
            ->from('CUSTOMER')
            ->pageSize(-1);
    }

    public function testFields(): void
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

        $fields = (new SelectBuilder())->fields(
            [
                'CUSTOMERID',
                'TOTALDUE',
                'WHENDUE',
                'TOTALENTERED',
                'TOTALDUE',
                'RECORDNO'
            ]
        )
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('ARINVOICE');

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAggregateFunctions(): void
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

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->avg('TOTALDUE')
            ->min('WHENDUE')
            ->max('TOTALENTERED')
            ->sum('TOTALDUE')
            ->count('RECORDNO')
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('ARINVOICE');

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testOrderBy(): void
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

        $fields = (new SelectBuilder())->fields(['CUSTOMERID', 'RECORDNO'])
            ->getFields();

        $orderBy = (new OrderBuilder())->ascending('TOTALDUE')
            ->descending('RECORDNO')
            ->getOrders();

        $query = (new Query('unittest'))->select($fields)
            ->from('ARINVOICE')
            ->orderBy($orderBy);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testEmptyOrderBy(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Field name for orderBy cannot be empty or null. Provide orders for orderBy in array."
        );

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $fields = (new SelectBuilder())->field('CUSTOMERID')
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('CUSTOMER')
            ->orderBy([]);

        $query->writeXML($xml);
    }

    public function testFilter(): void
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

        $fields = (new SelectBuilder())->fields(['CUSTOMERID', 'RECORDNO'])
            ->getFields();

        $filter = (new Filter('RECORDNO'))->lessThanOrEqualTo('10');

        $query = (new Query('unittest'))->select($fields)
            ->from('ARINVOICE')
            ->filter($filter);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * Test RECORDNO >= 1 && RECORDNO <= 100
     */
    public function testFilterAndCondition(): void
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

        $filter = new AndOperator(
            [
                (new Filter('RECORDNO'))->greaterThanOrEqualTo('1'),
                (new Filter('RECORDNO'))->lessThanOrEqualTo('100')
            ]
        );

        $fields = (new SelectBuilder())->fields(['CUSTOMERID', 'RECORDNO'])
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('ARINVOICE')
            ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * Test RECORDNO <= 10 || RECORDNO = 100 || RECORDNO = 1000 || RECORDNO = 10000
     */
    public function testFilterOrCondition(): void
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

        $filter = new OrOperator(
            [
                (new Filter('RECORDNO'))->lessThanOrEqualTo('10'),
                (new Filter('RECORDNO'))->equalTo('100'),
                (new Filter('RECORDNO'))->equalTo('1000'),
                (new Filter('RECORDNO'))->equalTo('10000')
            ]
        );

        $fields = (new SelectBuilder())->fields(['CUSTOMERID', 'RECORDNO'])
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('ARINVOICE')
            ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testFilterOrWithAndCondition(): void
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

        $batchnoAndState = new AndOperator(
            [
                (new Filter('BATCHNO'))->greaterThanOrEqualTo('1'),
                (new Filter('STATE'))->equalTo('Posted')
            ]
        );

        $journal = (new Filter('JOURNAL'))->equalTo('APJ');

        $filter = new OrOperator([$journal, $batchnoAndState]);

        $fields = (new SelectBuilder())->fields(['BATCHNO', 'RECORDNO', 'STATE'])
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('GLBATCH')
            ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAlternateFilterOrWithAndCondition(): void
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
        $andOperator->addFilter((new Filter('BATCHNO'))->greaterThanOrEqualTo('1'))
            ->addFilter((new Filter('STATE'))->equalTo('Posted'));

        $journal = (new Filter('JOURNAL'))->equalTo('APJ');

        $orOperator = new OrOperator(null);
        $orOperator->addFilter($journal)
            ->addFilter($andOperator);

        $fields = (new SelectBuilder())->fields(['BATCHNO', 'RECORDNO', 'STATE'])
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('GLBATCH')
            ->filter($orOperator);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testThreeLevelFilter(): void
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

        $APJAndState = new AndOperator(
            [
                (new Filter('JOURNAL'))->equalTo('APJ'),
                (new Filter('STATE'))->equalTo('Posted')
            ]
        );

        $RecordnoOr = new OrOperator(
            [
                (new Filter('RECORDNO'))->equalTo('168'),
                (new Filter('RECORDNO'))->equalTo('132')
            ]
        );

        $RCPTAndState = new AndOperator(
            [
                (new Filter('JOURNAL'))->equalTo('RCPT'),
                (new Filter('STATE'))->equalTo('Posted'),
                $RecordnoOr
            ]
        );

        $filter = new OrOperator([$APJAndState, $RCPTAndState]);

        $fields = (new SelectBuilder())->fields(['BATCHNO', 'RECORDNO', 'STATE'])
            ->getFields();

        $query = (new Query('unittest'))->select($fields)
            ->from('GLBATCH')
            ->filter($filter);

        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}