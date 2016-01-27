<?php

namespace Intacct\Xml\Request;

use XMLWriter;

class ControlTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Xml\Request\Control::__construct
     * @covers Intacct\Xml\Request\Control::getXml
     */
    public function testGetXmlDefaults()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<control>
    <senderid>testsenderid</senderid>
    <password>pass123!</password>
    <controlid>requestControlId</controlid>
    <uniqueid>false</uniqueid>
    <dtdversion>3.0</dtdversion>
    <policyid></policyid>
    <includewhitespace>false</includewhitespace>
</control>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $control = new Control($config);
        $control->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "sender_id" key not supplied in params
     */
    public function testGetXmlInvalidSenderId()
    {
        $config = [
            'sender_id' => null,
            'sender_password' => 'pass123!',
        ];
        
        $control = new Control($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "sender_password" key not supplied in params
     */
    public function testGetXmlInvalidSenderPassword()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => null,
        ];
        
        $control = new Control($config);
    }

    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @covers Intacct\Xml\Request\Control::setControlId
     * @covers Intacct\Xml\Request\Control::setUniqueId
     * @covers Intacct\Xml\Request\Control::getUniqueId
     * @covers Intacct\Xml\Request\Control::setDtdVersion
     * @covers Intacct\Xml\Request\Control::setIncludeWhitespace
     * @covers Intacct\Xml\Request\Control::getIncludeWhitespace
     * @covers Intacct\Xml\Request\Control::getXml
     */
    public function testGetXmlDefaultsOverride30()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => 'testcontrol',
            'unique_id' => true,
            'dtd_version' => '3.0',
            'policy_id' => 'testpolicy',
            'include_whitespace' => true,
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<control>
    <senderid>testsenderid</senderid>
    <password>pass123!</password>
    <controlid>testcontrol</controlid>
    <uniqueid>true</uniqueid>
    <dtdversion>3.0</dtdversion>
    <policyid>testpolicy</policyid>
    <includewhitespace>true</includewhitespace>
</control>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $control = new Control($config);
        $control->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @covers Intacct\Xml\Request\Control::setControlId
     * @covers Intacct\Xml\Request\Control::setUniqueId
     * @covers Intacct\Xml\Request\Control::getUniqueId
     * @covers Intacct\Xml\Request\Control::setDtdVersion
     * @covers Intacct\Xml\Request\Control::setIncludeWhitespace
     * @covers Intacct\Xml\Request\Control::getIncludeWhitespace
     * @covers Intacct\Xml\Request\Control::setDebug
     * @covers Intacct\Xml\Request\Control::getDebug
     * @covers Intacct\Xml\Request\Control::getXml
     */
    public function testGetXmlDefaultsOverride21()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => 'testcontrol',
            'unique_id' => true,
            'dtd_version' => '2.1',
            'policy_id' => 'testpolicy',
            'include_whitespace' => true,
            'debug' => true,
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<control>
    <senderid>testsenderid</senderid>
    <password>pass123!</password>
    <controlid>testcontrol</controlid>
    <uniqueid>true</uniqueid>
    <dtdversion>2.1</dtdversion>
    <policyid>testpolicy</policyid>
    <includewhitespace>true</includewhitespace>
    <debug>true</debug>
</control>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $control = new Control($config);
        $control->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage control_id must be between 1 and 256 characters in length
     */
    public function testGetXmlInvalidControlIdShort()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => '',
        ];
        
        $control = new Control($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage control_id must be between 1 and 256 characters in length
     */
    public function testGetXmlInvalidControlIdLong()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => str_repeat('1234567890', 30), //strlen 300
        ];
        
        $control = new Control($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage uniqueid not valid boolean type
     */
    public function testGetXmlInvalidUniqueId()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'unique_id' => 'true',
        ];
        
        $control = new Control($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage dtdversion is not a valid version
     */
    public function testGetXmlInvalidDtdVersion()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'dtd_version' => '1.2',
        ];
        
        $control = new Control($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage include_whitespace not valid boolean type
     */
    public function testGetXmlInvalidIncludeWhitespace()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'include_whitespace' => 'true',
        ];
        
        $control = new Control($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Control::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage debug not valid boolean type
     */
    public function testGetXmlInvalidDebug()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'debug' => 'true',
        ];
        
        $control = new Control($config);
    }

}
