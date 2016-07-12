<?php
/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Xml\Request;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ControlBlockTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Xml\Request\ControlBlock::__construct
     * @covers Intacct\Xml\Request\ControlBlock::getXml
     */
    public function testGetXmlDefaults()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => 'unittest',
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<control>
    <senderid>testsenderid</senderid>
    <password>pass123!</password>
    <controlid>unittest</controlid>
    <uniqueid>false</uniqueid>
    <dtdversion>3.0</dtdversion>
    <includewhitespace>false</includewhitespace>
</control>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $controlBlock = new ControlBlock($config);
        $controlBlock->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "sender_id" key not supplied in params
     */
    public function testGetXmlInvalidSenderId()
    {
        $config = [
            'sender_id' => null,
            'sender_password' => 'pass123!',
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "sender_password" key not supplied in params
     */
    public function testGetXmlInvalidSenderPassword()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => null,
        ];
        
        new ControlBlock($config);
    }

    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
     * @covers Intacct\Xml\Request\ControlBlock::setControlId
     * @covers Intacct\Xml\Request\ControlBlock::setUniqueId
     * @covers Intacct\Xml\Request\ControlBlock::getUniqueId
     * @covers Intacct\Xml\Request\ControlBlock::setDtdVersion
     * @covers Intacct\Xml\Request\ControlBlock::setIncludeWhitespace
     * @covers Intacct\Xml\Request\ControlBlock::getIncludeWhitespace
     * @covers Intacct\Xml\Request\ControlBlock::getXml
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

        $controlBlock = new ControlBlock($config);
        $controlBlock->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
     * @covers Intacct\Xml\Request\ControlBlock::setControlId
     * @covers Intacct\Xml\Request\ControlBlock::setUniqueId
     * @covers Intacct\Xml\Request\ControlBlock::getUniqueId
     * @covers Intacct\Xml\Request\ControlBlock::setDtdVersion
     * @covers Intacct\Xml\Request\ControlBlock::setIncludeWhitespace
     * @covers Intacct\Xml\Request\ControlBlock::getIncludeWhitespace
     * @covers Intacct\Xml\Request\ControlBlock::setDebug
     * @covers Intacct\Xml\Request\ControlBlock::getDebug
     * @covers Intacct\Xml\Request\ControlBlock::getXml
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

        $controlBlock = new ControlBlock($config);
        $controlBlock->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
     * @covers Intacct\Xml\Request\ControlBlock::setControlId
     */
    public function testGetXmlInvalidControlIdShort()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => '', //will set a random uuid
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
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
        
        new ControlBlock($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
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
        
        new ControlBlock($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
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
        
        new ControlBlock($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
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
        
        new ControlBlock($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\ControlBlock::__construct
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
        
        new ControlBlock($config);
    }
}
