<?php
/**
 * Copyright 2017 Sage Intacct, Inc.
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

/**
 * @coversDefaultClass \Intacct\Xml\Request\ControlBlock
 */
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

    public function testWriteXmlDefaults()
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
        $controlBlock->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "sender_id" key not supplied in params
     */
    public function testWriteXmlInvalidSenderId()
    {
        $config = [
            'sender_id' => null,
            'sender_password' => 'pass123!',
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "sender_password" key not supplied in params
     */
    public function testWriteXmlInvalidSenderPassword()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => null,
        ];
        
        new ControlBlock($config);
    }

    public function testWriteXmlDefaultsOverride30()
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
        $controlBlock->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlDefaultsOverride21()
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
        $controlBlock->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlInvalidControlIdShort()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => 'unittest',
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage control_id must be between 1 and 256 characters in length
     */
    public function testWriteXmlInvalidControlIdLong()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'control_id' => str_repeat('1234567890', 30), //strlen 300
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage uniqueid not valid boolean type
     */
    public function testWriteXmlInvalidUniqueId()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'unique_id' => 'true',
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage dtdversion is not a valid version
     */
    public function testWriteXmlInvalidDtdVersion()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'dtd_version' => '1.2',
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage include_whitespace not valid boolean type
     */
    public function testWriteXmlInvalidIncludeWhitespace()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'include_whitespace' => 'true',
        ];
        
        new ControlBlock($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage debug not valid boolean type
     */
    public function testWriteXmlInvalidDebug()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'debug' => 'true',
        ];
        
        new ControlBlock($config);
    }
}
