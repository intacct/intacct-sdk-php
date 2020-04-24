<?php

namespace Intacct\Tests\Functions\Common\QueryFilter;

use Intacct\Functions\Common\QueryFilter\Filter;
use Intacct\Xml\XMLWriter;

class FilterTest extends \PHPUnit\Framework\TestCase
{

    public function testFieldEqualTo()
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

        //(new FilterBuilder())->or([(new Filter('CUSTOMERID'))->equalto('10'),
        //                            (new Filter('RECORDNO'))->equalto('1000')]);

        //$condition1 = ( new FilterBuilder() )->where('CUSTOMERID')->equalto('10');
        //( new FilterBuilder() )->where(f1)->equalto(x)->and(where(f2)->equalto(10));
        /**  or([field("CUSTOMERID")->equalto('100'),
         * field("CUSTOMERID")->equalto('100'),
         * and([field("CUSTOMERID")->equalto('100'),
         * field("CUSTOMERID")->equalto('100'),
         * field("CUSTOMERID")->equalto('100'),
         * field("CUSTOMERID")->equalto('100')])
         *
         * ]);
         */
    }

    public function testFieldIsNull()
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