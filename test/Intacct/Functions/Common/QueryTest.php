<?php

namespace Intacct\Tests\Functions\Common;

use Intacct\Functions\Common\Query;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use TypeError;

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
        <select>
            <field>CUSTOMERID</field>
        </select>
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

    public function testAllParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <query>
        <select>
            <field>CUSTOMERID</field>
            <field>RECORDNO</field>
        </select>
        <object>CUSTOMER</object>
        <docparid>REPORT</docparid>
        <options>
            <caseinsensitive>true</caseinsensitive>
        </options>
        <pagesize>10</pagesize>
        <offset>5</offset>
    </query>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ])
                                          ->from('CUSTOMER')
                                          ->docparid('REPORT')
                                          ->caseinsensitive(true)
                                          ->pagesize(10)
                                          ->offset(5);

        $query->writeXML($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object Name is required for query; set through method from setter.
     */
    public function testNoFromObject()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ]);

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Select fields are required for query; set through method select setter.
     */
    public function testNoSelectFields()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->from('CUSTOMER');

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Select fields are required for query; set through method select setter.
     */
    public function testMissingRequiredParams()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') );

        $query->writeXML($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object name for setting from cannot be empty or null. Set object name using from
     *                           setter.
     */
    public function testEmptyStringFromObject()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $query = ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ])
                                          ->from('');

        $query->writeXML($xml);
    }

    /**
     * @expectedException TypeError
     */
    public function testNullStringSelectField()
    {
        ( new Query('unittest') )->select(null)
                                 ->from('CUSTOMER');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for select cannot be empty or null. Provide fields for select in array.
     */
    public function testNullStringInSelectFieldArray()
    {
        ( new Query('unittest') )->select([ 'CUSTOMERID', null ])
                                 ->from('CUSTOMER');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for select cannot be empty or null. Provide fields for select in array.
     */
    public function testEmptyStringInSelectFieldArray()
    {
        ( new Query('unittest') )->select([ 'CUSTOMERID', '' ])
                                 ->from('CUSTOMER');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Fields for select cannot be empty or null. Provide fields for select in array.
     */
    public function testEmptyArraySelectFields()
    {
        ( new Query('unittest') )->select([])
                                 ->from('CUSTOMER');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage docparid cannot be empty. Set docparid with valid document identifier.
     */
    public function testNullDocparid()
    {
        ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ])
                                 ->from('CUSTOMER')
                                 ->docparid(null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage docparid cannot be empty. Set docparid with valid document identifier.
     */
    public function testEmptyDocparid()
    {
        ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ])
                                 ->from('CUSTOMER')
                                 ->docparid('');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage offset cannot be negative. Set offset to zero or greater than zero.
     */
    public function testNegativeOffset()
    {
        ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ])
                                 ->from('CUSTOMER')
                                 ->offset(-1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage pagesize cannot be negative. Set pagesize greater than zero.
     */
    public function testNegativePageSize()
    {
        ( new Query('unittest') )->select([ 'CUSTOMERID', 'RECORDNO' ])
                                 ->from('CUSTOMER')
                                 ->pagesize(-1);
    }
}