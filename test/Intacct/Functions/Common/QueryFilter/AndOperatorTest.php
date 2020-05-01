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

namespace Intacct\Functions\Common\QueryFilter;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\QueryFilter\AndOperator
 */
class AndOperatorTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Test RECORDNO >= 1 && RECORDNO <= 100
     */
    public function testAndCondition()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
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
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = new AndOperator([ ( new Filter('RECORDNO') )->greaterthanorequalto('1'),
                                    ( new Filter('RECORDNO') )->lessthanorequalto('100') ]);

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Two or more FilterInterface objects required for this Operator type.
     */
    public function testSingleFilter()
    {
        new AndOperator([ ( new Filter('RECORDNO') )->greaterthanorequalto('1') ]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Two or more FilterInterface objects required for this Operator type.
     */
    public function testEmptyFilter()
    {
        new AndOperator([]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Two or more FilterInterface objects required for this Operator type.
     */
    public function testNullFilter()
    {
        new AndOperator(null);
    }
}