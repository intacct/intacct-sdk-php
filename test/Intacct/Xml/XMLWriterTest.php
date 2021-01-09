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

namespace Intacct\Xml;

/**
 * @coversDefaultClass \Intacct\Xml\XMLWriter
 */
class XMLWriterTest extends \PHPUnit\Framework\TestCase
{

    public function testWriteElement(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>
<report>ReportName</report>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $xml->writeElement('report', "ReportName", true);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteNullAndNotNullElements(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>
<report></report>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $xml->writeElement('report', null, true);
        $xml->writeElement('hello', null);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteElementAsBool(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>
<isreport>true</isreport>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $xml->writeElement('isreport', true, true);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteElementAsDate(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>
<billdate>03/01/2016</billdate>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $date = new \DateTime("2016-03-01");

        $xml->writeElementDate('billdate', $date);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteElementAsDateTime(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>
<createdAt>03/01/2016 12:30:59</createdAt>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $dateTime = new \DateTime("2016-03-01T12:30:59");

        $xml->writeElementDateTime('createdAt', $dateTime);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteElementAsNull(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>\n
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $xml->writeElement("report");

        $this->assertEquals($expected, $xml->flush());
    }

    public function testDateSplitElements(): void
    {
        $expected = <<<EOF
<?xml version="1.0"?>
<date>
    <year>2016</year>
    <month>03</month>
    <day>01</day>
</date>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $date = new \DateTime("2016-03-01");

        $xml->startElement("date");

        $xml->writeDateSplitElements($date, true);

        $xml->endElement();

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
