<?php

namespace Intacct\Xml\Response;

class ControlTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Control
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

        $this->object = $stub->getControl();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Xml\Response\Control::getStatus
     */
    public function testGetStatus()
    {
        $this->assertEquals('success', $this->object->getStatus());
    }

    /**
     * @covers Intacct\Xml\Response\Control::getSenderId
     */
    public function testGetSenderId()
    {
        $this->assertEquals('intacct_dev', $this->object->getSenderId());
    }

    /**
     * @covers Intacct\Xml\Response\Control::getControlId
     */
    public function testGetControlId()
    {
        $this->assertEquals('ControlIdHere', $this->object->getControlId());
    }

    /**
     * @covers Intacct\Xml\Response\Control::getUniqueId
     */
    public function testGetUniqueId()
    {
        $this->assertEquals('false', $this->object->getUniqueId());
    }

    /**
     * @covers Intacct\Xml\Response\Control::getDtdVersion
     */
    public function testGetDtdVersion()
    {
        $this->assertEquals('3.0', $this->object->getDtdVersion());
    }
    
    /**
     * @covers Intacct\Xml\Response\Control::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Control block is missing status element
     */
    public function testMissingStatusElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control/>
</response>
EOF;

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }
    
    /**
     * @covers Intacct\Xml\Response\Control::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Control block is missing senderid element
     */
    public function testMissingSenderIdElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <!--<senderid>intacct_dev</senderid>-->
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
    }
    
    /**
     * @covers Intacct\Xml\Response\Control::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Control block is missing controlid element
     */
    public function testMissingControlIdElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <!--<controlid>ControlIdHere</controlid>-->
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }
    
    /**
     * @covers Intacct\Xml\Response\Control::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Control block is missing uniqueid element
     */
    public function testMissingUniqueIdElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <!--<uniqueid>false</uniqueid>-->
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }
    
    /**
     * @covers Intacct\Xml\Response\Control::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Control block is missing dtdversion element
     */
    public function testMissingDtdVersionElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <!--<dtdversion>3.0</dtdversion>-->
      </control>
</response>
EOF;

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

}
