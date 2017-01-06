<?php

/**
 * Copyright 2017 Intacct Corporation.
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
class ExpressionFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testDefaultConstruct()
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

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Field Name is required for an expression filter
     */
    public function testNoFieldName()
    {
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

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Operator is required for an expression filter
     */
    public function testNoOperator()
    {
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
