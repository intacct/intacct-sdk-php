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
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Common\QueryFilter\Filter
 */
class FilterTest extends \PHPUnit\Framework\TestCase
{

    public function testEqualTo()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
    <equalto>
        <field>CUSTOMERID</field>
        <value>10</value>
    </equalto>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('CUSTOMERID') )->equalto('10');

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testLessThanOrEqualTo()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<lessthanorequalto>
    <field>RECORDNO</field>
    <value>100</value>
</lessthanorequalto>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('RECORDNO') )->lessthanorequalto('100');

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testIsNull()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<isnull>
    <field>DESCRIPTION</field>
</isnull>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('DESCRIPTION') )->isnull();

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}