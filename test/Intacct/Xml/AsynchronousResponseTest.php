<?php

namespace Intacct\Xml;

class AsynchronousResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AsynchronousResponse
     */
    protected $object;

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
     * @covers Intacct\Xml\AsynchronousResponse::__construct
     * @covers Intacct\Xml\AsynchronousResponse::setAcknowledgement
     * @covers Intacct\Xml\AsynchronousResponse::getAcknowledgement
     */
    public function testGetAcknowledgement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <acknowledgement>
            <status>success</status>
      </acknowledgement>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $response = new AsynchronousResponse($xml);
        $acknowledgement = $response->getAcknowledgement();
        $this->assertThat($acknowledgement, $this->isInstanceOf('Intacct\Xml\Response\Acknowledgement'));
    }
    
    /**
     * @covers Intacct\Xml\AsynchronousResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Response is missing acknowledgement block
     */
    public function testMissingAcknowledgementBlock()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $response = new AsynchronousResponse($xml);
    }

}
