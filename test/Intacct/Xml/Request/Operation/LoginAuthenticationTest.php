<?php

namespace Intacct\Xml\Request\Operation;

use XMLWriter;

class LoginAuthenticationTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Xml\Request\Operation\LoginAuthentication::__construct
     * @covers Intacct\Xml\Request\Operation\LoginAuthentication::getXml
     */
    public function testGetXml()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<authentication>
    <login>
        <userid>testuser</userid>
        <companyid>testcompany</companyid>
        <password>testpass</password>
    </login>
</authentication>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument();

        $loginAuth = new LoginAuthentication($config);
        $loginAuth->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation\LoginAuthentication::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "company_id" key not supplied in params
     */
    public function testInvalidCompanyId()
    {
        $config = [
            'company_id' => null,
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        
        $loginAuth = new LoginAuthentication($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation\LoginAuthentication::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_id" key not supplied in params
     */
    public function testInvalidUserId()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => null,
            'user_password' => 'testpass',
        ];
        
        $loginAuth = new LoginAuthentication($config);
    }
    
    /**
     * @covers Intacct\Xml\Request\Operation\LoginAuthentication::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_password" key not supplied in params
     */
    public function testInvalidUserPass()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => null,
        ];
        
        $loginAuth = new LoginAuthentication($config);
    }

}
