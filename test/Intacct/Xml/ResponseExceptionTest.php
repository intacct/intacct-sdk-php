<?php

namespace Intacct\Xml;

use Intacct\Xml\SynchronousResponse;

class ResponseExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ResponseException
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
     * @covers Intacct\Xml\ResponseException::__construct
     * @covers Intacct\Xml\ResponseException::getErrors
     */
    public function testGetErrors()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>failure</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <errormessage>
            <error>
                  <errorno>XL03000006</errorno>
                  <description></description>
                  <description2>test is not a valid transport policy.</description2>
                  <correction></correction>
            </error>
      </errormessage>
</response>
EOF;
        try {
            $response = new SynchronousResponse($xml);
        } catch (ResponseException $ex) {
            $this->assertInternalType('array', $ex->getErrors());
        }
    }

}
