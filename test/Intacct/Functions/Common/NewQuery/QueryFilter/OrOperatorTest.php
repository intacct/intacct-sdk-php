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

namespace Intacct\Functions\Common\NewQuery\QueryFilter;

use Exception;
use Intacct\Xml\XMLWriter;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @coversDefaultClass \Intacct\Functions\Common\NewQuery\QueryFilter\OrOperator
 */
class OrOperatorTest extends TestCase
{

    /**
     * Test RECORDNO <= 10 || RECORDNO = 100 || RECORDNO = 1000 || RECORDNO = 10000
     */
    public function testOrCondition(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
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

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testSingleFilter(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Two or more FilterInterface objects required for or");

        $xml = new XMLWriter();

        $filter = new OrOperator([(new Filter('RECORDNO'))->greaterThanOrEqualTo('1')]);

        $filter->writeXML($xml);
    }

    public function testEmptyFilter(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Two or more FilterInterface objects required for or");

        $xml = new XMLWriter();

        $filter = new OrOperator([]);

        $filter->writeXML($xml);
    }

    public function testNullFilter(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Two or more FilterInterface objects required for or");

        $xml = new XMLWriter();

        $filter = new OrOperator(null);

        $filter->writeXML($xml);
    }

    public function testAddFilter(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
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
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = new OrOperator(null);
        $filter->addFilter((new Filter('RECORDNO'))->lessThanOrEqualTo('10'))
            ->addFilter((new Filter('RECORDNO'))->equalTo('100'))
            ->addFilter((new Filter('RECORDNO'))->equalTo('1000'))
            ->addFilter((new Filter('RECORDNO'))->equalTo('10000'));

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAddFilterNull(): void
    {
        $this->expectException(TypeError::class);

        $xml = new XMLWriter();

        $filter = new OrOperator(null);

        $filter->addFilter(null);

        $filter->writeXML($xml);
    }
}