<?php

namespace Intacct\Xml\Request;

use Intacct\Xml\Request\Operation\Content;
use Intacct\Xml\Request\Operation\Content\GetAPISession;
use XMLWriter;

class OperationTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Xml\Request\Operation::__construct
     * @covers Intacct\Xml\Request\Operation::setContent
     * @covers Intacct\Xml\Request\Operation::getXml
     * @covers Intacct\Xml\Request\Operation::getTransaction
     */
    public function testGetXmlSession()
    {
        $config = [
            'session_id' => 'fakesession..',
        ];
        
        $content = new Content();
        $func = new GetAPISession();
        $content->append($func);
        
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

        $operation = new Operation($config, $content);
        $operation->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation::__construct
     * @covers Intacct\Xml\Request\Operation::setContent
     * @covers Intacct\Xml\Request\Operation::getXml
     * @covers Intacct\Xml\Request\Operation::getTransaction
     */
    public function testGetXmlLogin()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        
        $content = new Content();
        $func = new GetAPISession();
        $content->append($func);
        
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

        $operation = new Operation($config, $content);
        $operation->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation::__construct
     * @covers Intacct\Xml\Request\Operation::setTransaction
     * @covers Intacct\Xml\Request\Operation::getXml
     * @covers Intacct\Xml\Request\Operation::getTransaction
     */
    public function testGetXmlTransaction()
    {
        $config = [
            'session_id' => 'fakesession..',
            'transaction' => true,
        ];
        
        $content = new Content();
        $func = new GetAPISession();
        $content->append($func);
        
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

        $operation = new Operation($config, $content);
        $operation->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation::__construct
     * @covers Intacct\Xml\Request\Operation::setTransaction
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage transaction not valid boolean type
     */
    public function testTransactionNotBoolean()
    {
        $config = [
            'session_id' => 'fakesession..',
            'transaction' => 'true',
        ];
        
        $content = new Content();
        $func = new GetAPISession();
        $content->append($func);
        $operation = new Operation($config, $content);
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation::__construct
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
        
        $content = new Content();
        $func = new GetAPISession();
        $content->append($func);
        $operation = new Operation($config, $content);
    }

}
