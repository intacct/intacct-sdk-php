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
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\GetList\GetList
 */
class GetListTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <get_list object="smarteventlog" showprivate="false" />
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new GetList('unittest');
        $exp->setObjectName('smarteventlog');

        $exp->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testExpressionFilter(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <get_list object="smarteventlog" showprivate="false">
        <filter>
            <expression>
                <field>fieldid</field>
                <operator>=</operator>
                <value>1234</value>
            </expression>
        </filter>
    </get_list>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new GetList('unittest');
        $exp->setObjectName('smarteventlog');

        $filter = new ExpressionFilter();
        $filter->setFieldName('fieldid');
        $filter->setOperator(ExpressionFilter::OPERATOR_EQUAL_TO);
        $filter->setValue('1234');

        $exp->setFilter($filter);

        $exp->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testLogicalFilter(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <get_list object="smarteventlog" showprivate="false">
        <filter>
            <logical logical_operator="or">
                <expression>
                    <field>fieldid</field>
                    <operator>=</operator>
                    <value>1234</value>
                </expression>
                <expression>
                    <field>anotherfieldid</field>
                    <operator>=</operator>
                    <value>5678</value>
                </expression>
            </logical>
        </filter>
    </get_list>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new GetList('unittest');
        $exp->setObjectName('smarteventlog');

        $filter1 = new ExpressionFilter();
        $filter1->setFieldName('fieldid');
        $filter1->setOperator(ExpressionFilter::OPERATOR_EQUAL_TO);
        $filter1->setValue('1234');

        $filter2 = new ExpressionFilter();
        $filter2->setFieldName('anotherfieldid');
        $filter2->setOperator(ExpressionFilter::OPERATOR_EQUAL_TO);
        $filter2->setValue('5678');

        $logical = new LogicalFilter();
        $logical->setOperator(LogicalFilter::OPERATOR_OR);
        $logical->setFilters([
            $filter1,
            $filter2,
        ]);

        $exp->setFilter($logical);

        $exp->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoFieldName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Object Name is required for get_list");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new GetList();

        $exp->writeXml($xml);
    }
}
