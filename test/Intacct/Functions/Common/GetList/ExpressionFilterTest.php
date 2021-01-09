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
 * @coversDefaultClass \Intacct\Functions\Common\GetList\ExpressionFilter
 */
class ExpressionFilterTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<expression>
    <field>recordno</field>
    <operator>&gt;=</operator>
    <value>1234</value>
</expression>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new ExpressionFilter();
        $exp->setFieldName('recordno');
        $exp->setOperator(ExpressionFilter::OPERATOR_GREATER_THAN_OR_EQUAL_TO);
        $exp->setValue(1234);

        $exp->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoFieldName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field Name is required for an expression filter");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new ExpressionFilter();
        //$exp->setFieldName('recordno');
        $exp->setOperator(ExpressionFilter::OPERATOR_GREATER_THAN_OR_EQUAL_TO);
        $exp->setValue(1234);

        $exp->writeXml($xml);
    }

    public function testNoOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Operator is required for an expression filter");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new ExpressionFilter();
        $exp->setFieldName('recordno');
        //$exp->setOperator(ExpressionFilter::OPERATOR_GREATER_THAN_OR_EQUAL_TO);
        $exp->setValue(1234);

        $exp->writeXml($xml);
    }
}
