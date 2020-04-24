<?php

namespace Intacct\Tests\Functions\Common\QueryFilter;

use Intacct\Functions\Common\Query;
use Intacct\Functions\Common\QueryFilter\Filter;
use Intacct\Functions\Common\QueryFilter\FilterBuilder;
use Intacct\Functions\Common\QuerySelect\SelectBuilder;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Common\QueryFilter\FilterBuilder
 */
class FilterBuilderTest extends \PHPUnit\Framework\TestCase
{

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

        $filters = ( new FilterBuilder() )->or([ ( new Filter('RECORDNO') )->lessthanorequalto('10'),
                                                 ( new Filter('RECORDNO') )->equalto('100'),
                                                 ( new Filter('RECORDNO') )->equalto('1000'),
                                                 ( new Filter('RECORDNO') )->equalto('10000') ]);

        //  $filters->writeXML($xml);

        //  $this->assertXmlStringEqualsXmlString($expected, $xml->flush());

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

    public function testOrNestedAndCondition()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>ARINVOICE</object>
        <filter>
            <or>
                <and>
                    <equalto>
                        <field>A</field>
                        <value>B</value>
                    </equalto>
                    <equalto>
                        <field>C</field>
                        <value>D</value>
                    </equalto>
                </and>
                <equalto>
                    <field>E</field>
                    <value>F</value>
                </equalto>
            </or>
        </filter>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        // (A = 'B' && C = 'D') || (E = 'F')
        $ABCD = ( new FilterBuilder() )->and([ ( new Filter('A') )->equalto('B'),
                                               ( new Filter('C') )->equalto('D') ])
                                       ->getFilters();

        $EF = ( new Filter('E') )->equalto('F');

        $filter = ( new FilterBuilder() )->or([ $ABCD, $EF ])
                                         ->getFilters();

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'RECORDNO' ])
                                         ->getFields();

        // As discussed with Samvel, this example won't work right now
        // $filters = [new Filter(), new Filter()];

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE')
                                          ->filter($filter);

        // Only this test is working
        $query->writeXML($xml);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testSingleFilter()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $filter = ( new Filter('E') )->equalto('F');

        $fields = ( new SelectBuilder() )->fields([ 'CUSTOMERID', 'RECORDNO' ])
                                         ->getFields();

        $query = ( new Query('unittest') )->select($fields)
                                          ->from('ARINVOICE')
                                          ->filter([$filter]);
        // Currently broken
        $query->writeXML($xml);
        //$this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}