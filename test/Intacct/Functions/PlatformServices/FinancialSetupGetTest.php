<?php

namespace Intacct\Functions\PlatformServices;

use Intacct\Xml\XMLWriter;

class FinancialSetupGetTest extends \PHPUnit\Framework\TestCase
{

	public function testGenerateXml(): void
	{
		$expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <getFinancialSetup />
</function>
EOF;

		$xml = new XMLWriter();
		$xml->openMemory();
		$xml->setIndent(true);
		$xml->setIndentString('    ');
		$xml->startDocument();

		$record = new FinancialSetupGet('unittest');

		$record->writeXml($xml);

		$this->assertXmlStringEqualsXmlString($expected, $xml->flush());
	}
}