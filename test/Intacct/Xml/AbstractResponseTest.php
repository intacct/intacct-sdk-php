<?php

namespace Intacct\Xml;

class AbstractResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractResponse
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
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage XML could not be parsed properly
     */
    public function testConstructInvalidXml()
    {
        $xml = '<bad></xml>';

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Response is missing control block
     */
    public function testConstructMissingControlBlock()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <nocontrolblock/>
</response>
EOF;

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @covers Intacct\Xml\ResponseException::__construct
     * @expectedException Intacct\Xml\ResponseException
     * @expectedExceptionMessage Response control status failure
     */
    public function testConstructControlFailure()
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

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @covers Intacct\Xml\AbstractResponse::setControl
     * @covers Intacct\Xml\AbstractResponse::getControl
     */
    public function testGetControl()
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

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
        $this->assertThat($stub, $this->isInstanceOf('Intacct\Xml\AbstractResponse'));
        $control = $stub->getControl();
        $this->assertThat($control, $this->isInstanceOf('Intacct\Xml\Response\Control'));
    }

}
