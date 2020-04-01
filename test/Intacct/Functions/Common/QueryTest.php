<?php

namespace Intacct\Tests\Functions\Common;

use Intacct\Functions\Common\Query;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query
 */
class QueryTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>CUSTOMERID</select>
        <object>CUSTOMER</object>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->select([ 'CUSTOMERID' ])
                                          ->from('CUSTOMER');

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRedoParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>CUSTOMERID</select>
        <object>CUSTOMER</object>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->select([ 'CUSTOMERID' ])
                                          ->from('CUSTOMER');

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}