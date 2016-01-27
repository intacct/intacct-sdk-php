<?php

namespace Intacct\Xml;

class SynchronousResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SynchronousResponse
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
     * @covers Intacct\Xml\SynchronousResponse::__construct
     * @covers Intacct\Xml\SynchronousResponse::setOperation
     * @covers Intacct\Xml\SynchronousResponse::getOperation
     */
    public function testGetOperation()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-22T20:58:27-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>fAkESesSiOnId..</sessionid>
                              <endpoint>https://api.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;

        $response = new SynchronousResponse($xml);
        $operation = $response->getOperation();
        $this->assertThat($operation, $this->isInstanceOf('Intacct\Xml\Response\Operation'));
    }

    /**
     * @covers Intacct\Xml\SynchronousResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Response is missing operation block
     */
    public function testMissingOperationBlock()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $response = new SynchronousResponse($xml);
    }

}
