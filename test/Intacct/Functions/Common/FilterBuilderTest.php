<?php

namespace Intacct\Tests\Functions\Common;

use Intacct\Functions\Common\FilterBuilder;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Common\FilterBuilder
 */
class FilterBuilderTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
    <filter>
        <equalto>
			<field>CUSTOMERID</field>
			<value>10</value>
		</equalto>
	</filter>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new FilterBuilder() )->where('CUSTOMERID')
                                         ->equalto('10');

        $filter->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}