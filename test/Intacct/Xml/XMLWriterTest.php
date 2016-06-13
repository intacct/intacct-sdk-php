<?php


namespace Intacct\Xml;

use Intacct\Xml\XMLWriter;
use Intacct\Fields\Date;

class XMLWriterTest extends \PHPUnit_Framework_TestCase
{

    public function testWriteElement()
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

    public function testWriteNullElement()
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

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteElementAsBool()
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

    public function testWriteElementAsNull()
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

    public function testDateSplitElements()
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

        $date = new Date("2016-03-01");

        $xml->startElement("date");

        $xml->writeDateSplitElements($date, true);

        $xml->endElement();

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}