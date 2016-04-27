<?php

/*
 * Copyright 2016 Intacct Corporation.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Intacct\Tests\Xml\Request;

use Intacct\Xml\Request\Operation\ContentBlock;
use Intacct\Xml\Request\Operation\Content\GetAPISession;
use XMLWriter;
use InvalidArgumentException;
use Intacct\Xml\Request\OperationBlock;

class OperationBlockTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Xml\Request\OperationBlock::__construct
     * @covers Intacct\Xml\Request\OperationBlock::setContent
     * @covers Intacct\Xml\Request\OperationBlock::getXml
     * @covers Intacct\Xml\Request\OperationBlock::getTransaction
     */
    public function testGetXmlSession()
    {
        $config = [
            'session_id' => 'fakesession..',
        ];
        
        $contentBlock = new ContentBlock();
        $func = new GetAPISession();
        $contentBlock->append($func);
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<operation transaction="false">
    <authentication>
        <sessionid>fakesession..</sessionid>
    </authentication>
    <content>
        <function controlid="getSession">
            <getAPISession/>
        </function>
    </content>
</operation>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $operation = new OperationBlock($config, $contentBlock);
        $operation->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\OperationBlock::__construct
     * @covers Intacct\Xml\Request\OperationBlock::setContent
     * @covers Intacct\Xml\Request\OperationBlock::getXml
     * @covers Intacct\Xml\Request\OperationBlock::getTransaction
     */
    public function testGetXmlLogin()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        
        $contentBlock = new ContentBlock();
        $func = new GetAPISession();
        $contentBlock->append($func);
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<operation transaction="false">
    <authentication>
        <login>
            <userid>testuser</userid>
            <companyid>testcompany</companyid>
            <password>testpass</password>
        </login>
    </authentication>
    <content>
        <function controlid="getSession">
            <getAPISession/>
        </function>
    </content>
</operation>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $operation = new OperationBlock($config, $contentBlock);
        $operation->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\OperationBlock::__construct
     * @covers Intacct\Xml\Request\OperationBlock::setTransaction
     * @covers Intacct\Xml\Request\OperationBlock::getXml
     * @covers Intacct\Xml\Request\OperationBlock::getTransaction
     */
    public function testGetXmlTransaction()
    {
        $config = [
            'session_id' => 'fakesession..',
            'transaction' => true,
        ];
        
        $contentBlock = new ContentBlock();
        $func = new GetAPISession();
        $contentBlock->append($func);
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<operation transaction="true">
    <authentication>
        <sessionid>fakesession..</sessionid>
    </authentication>
    <content>
        <function controlid="getSession">
            <getAPISession/>
        </function>
    </content>
</operation>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $operation = new OperationBlock($config, $contentBlock);
        $operation->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\OperationBlock::__construct
     * @covers Intacct\Xml\Request\OperationBlock::setTransaction
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage transaction not valid boolean type
     */
    public function testTransactionNotBoolean()
    {
        $config = [
            'session_id' => 'fakesession..',
            'transaction' => 'true',
        ];
        
        $contentBlock = new ContentBlock();
        $func = new GetAPISession();
        $contentBlock->append($func);
        new OperationBlock($config, $contentBlock);
    }
    
    /**
     * @covers Intacct\Xml\Request\OperationBlock::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "company_id", "user_id", and "user_password" keys, or "session_id" key, not supplied in params
     */
    public function testNoCredentials()
    {
        $config = [
            'session_id' => null,
            'company_id' => null,
            'user_id' => null,
            'user_password' => null,
        ];
        
        $contentBlock = new ContentBlock();
        $func = new GetAPISession();
        $contentBlock->append($func);
        new OperationBlock($config, $contentBlock);
    }

}
