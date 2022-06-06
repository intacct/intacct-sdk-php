<?php

namespace Intacct\Functions\AccountsPayable;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

class BillLineTaxEntriesCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<taxentry>
    <detailid>TaxName</detailid>
</taxentry>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $taxentries = new BillLineTaxEntriesCreate();
        $taxentries->setTaxId('TaxName');

        $taxentries->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<taxentry>
    <detailid>TaxName</detailid>
    <trx_tax>10</trx_tax>
</taxentry>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $taxEntries = new BillLineTaxEntriesCreate();
        $taxEntries->setTaxId('TaxName');
        $taxEntries->setTaxValue(10);

        $taxEntries->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }


}
