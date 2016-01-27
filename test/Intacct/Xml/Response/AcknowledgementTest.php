<?php

namespace Intacct\Xml\Response;

use Intacct\Xml\AsynchronousResponse;

class AcknowledgementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Acknowledgement
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <acknowledgement>
            <status>success</status>
      </acknowledgement>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $response = new AsynchronousResponse($xml);
        $this->object = $response->getAcknowledgement();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Xml\Response\Acknowledgement::getStatus
     */
    public function testGetStatus()
    {
        $this->assertEquals('success', $this->object->getStatus());
    }
    
    /**
     * @covers Intacct\Xml\Response\Acknowledgement::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Acknowledgement block is missing status element
     */
    public function testMissingStatusElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <acknowledgement/>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $response = new AsynchronousResponse($xml);
    }

}
