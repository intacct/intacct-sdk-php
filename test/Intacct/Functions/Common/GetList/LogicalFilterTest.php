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

namespace Intacct\Functions\Common\GetList;

use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Common\GetList\LogicalFilter
 */
class LogicalFilterTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<logical logical_operator="and">
    <expression>
        <field>recordno</field>
        <operator>&gt;=</operator>
        <value>1234</value>
    </expression>
    <logical logical_operator="or">
        <expression>
            <field>ownerobject</field>
            <operator>=</operator>
            <value>PROJECT</value>
        </expression>
        <expression>
            <field>ownerobject</field>
            <operator>=</operator>
            <value>CUSTOMER</value>
        </expression>
    </logical>
</logical>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp1 = new ExpressionFilter();
        $exp1->setFieldName('recordno');
        $exp1->setOperator(ExpressionFilter::OPERATOR_GREATER_THAN_OR_EQUAL_TO);
        $exp1->setValue(1234);

        $exp2 = new ExpressionFilter();
        $exp2->setFieldName('ownerobject');
        $exp2->setOperator(ExpressionFilter::OPERATOR_EQUAL_TO);
        $exp2->setValue('PROJECT');

        $exp3 = new ExpressionFilter();
        $exp3->setFieldName('ownerobject');
        $exp3->setOperator(ExpressionFilter::OPERATOR_EQUAL_TO);
        $exp3->setValue('CUSTOMER');

        $logical2 = new LogicalFilter();
        $logical2->setOperator(LogicalFilter::OPERATOR_OR);
        $logical2->setFilters([
            $exp2,
            $exp3,
        ]);

        $logical1 = new LogicalFilter();
        $logical1->setOperator(LogicalFilter::OPERATOR_AND);
        $logical1->setFilters([
            $exp1,
            $logical2,
        ]);

        $logical1->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNotEnoughFilters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Logical Filters count must be 2 or more");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = new LogicalFilter();

        $filter->writeXml($xml);
    }
}
