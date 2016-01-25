<?php

namespace Intacct\Xml\Request\Operation;

use XMLWriter;

class SessionAuthenticationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Xml\Request\Operation\SessionAuthentication::__construct
     * @covers Intacct\Xml\Request\Operation\SessionAuthentication::getXml
     */
    public function testGetXml()
    {
        $config = [
            'session_id' => 'testsessionid..',
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<authentication>
    <sessionid>testsessionid..</sessionid>
</authentication>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndentString('    ');
        $xml->startDocument();

        $sessionAuth = new SessionAuthentication($config);
        $sessionAuth->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation\SessionAuthentication::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "session_id" key not supplied in params
     */
    public function testInvalidSession()
    {
        $config = [
            'session_id' => null,
        ];
        
        $sessionAuth = new SessionAuthentication($config);
    }

}
