<?php

namespace Intacct\Xml\Request\Operation\Content;

use XMLWriter;

class GetAPISessionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GetAPISession
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new GetAPISession();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\GetAPISession::__construct
     * @covers Intacct\Xml\Request\Operation\Content\GetAPISession::getXml
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="getSession">
    <getAPISession/>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument();

        $this->object->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

}
