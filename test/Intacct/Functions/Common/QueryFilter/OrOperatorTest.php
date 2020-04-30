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

namespace Intacct\Tests\Functions\Common\QueryFilter;

use Intacct\Functions\Common\QueryFilter\Filter;
use Intacct\Functions\Common\QueryFilter\OrOperator;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Common\QueryFilter\OrOperator
 */
class OrOperatorTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Test RECORDNO <= 10 || RECORDNO = 100 || RECORDNO = 1000 || RECORDNO = 10000
     */
    public function testOrCondition()
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

        $filter = new OrOperator([ ( new Filter('RECORDNO') )->lessthanorequalto('10'),
                                   ( new Filter('RECORDNO') )->equalto('100'),
                                   ( new Filter('RECORDNO') )->equalto('1000'),
                                   ( new Filter('RECORDNO') )->equalto('10000') ]);

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}