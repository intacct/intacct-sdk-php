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

namespace Intacct\Functions\Common\NewQuery\QueryFilter;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\NewQuery\QueryFilter\Filter
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

        $filter = ( new Filter('CUSTOMERID') )->equalTo('10');

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNotEqualTo()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
    <notequalto>
        <field>CUSTOMERID</field>
        <value>10</value>
    </notequalto>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('CUSTOMERID') )->notEqualTo('10');

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testLessThan()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<lessthan>
    <field>RECORDNO</field>
    <value>100</value>
</lessthan>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('RECORDNO') )->lessThan('100');

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

        $filter = ( new Filter('RECORDNO') )->lessThanOrEqualTo('100');

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGreaterThan()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<greaterthan>
    <field>RECORDNO</field>
    <value>100</value>
</greaterthan>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('RECORDNO') )->greaterThan('100');

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGreaterThanOrEqualTo()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<greaterthanorequalto>
    <field>RECORDNO</field>
    <value>100</value>
</greaterthanorequalto>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('RECORDNO') )->greaterThanOrEqualTo('100');

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testBetween()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<between>
    <field>WHENDUE</field>
    <value>10/01/2019</value>
    <value>12/31/2019</value>
</between>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('WHENDUE') )->between([ '10/01/2019', '12/31/2019' ]);

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Two strings expected for between filter
     */
    public function testOneBetween()
    {
        ( new Filter('WHENDUE') )->between([ '10/01/2019' ]);
    }

    public function testIn()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<in>
    <field>DEPARTMENTID</field>
    <value>04</value>
    <value>05</value>
    <value>06</value>
    <value>07</value>
</in>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('DEPARTMENTID') )->in([ '04', '05', '06', '07' ]);

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNotIn()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<notin>
    <field>DEPARTMENTID</field>
    <value>04</value>
    <value>05</value>
    <value>06</value>
    <value>07</value>
</notin>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('DEPARTMENTID') )->notIn([ '04', '05', '06', '07' ]);

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testLike()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<like>
    <field>VENDORNAME</field>
    <value>B%</value>
</like>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('VENDORNAME') )->like('B%');

        $filter->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNotLike()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<notlike>
    <field>VENDORNAME</field>
    <value>ACME%</value>
</notlike>
EOF;
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('VENDORNAME') )->notLike('ACME%');

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

        $filter = ( new Filter('DESCRIPTION') )->isNull();

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testIsNotNull()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<isnotnull>
    <field>DESCRIPTION</field>
</isnotnull>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('DESCRIPTION') )->isNotNull();

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}