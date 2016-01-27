<?php

namespace Intacct\Credentials;

class SenderCredentialsTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @covers Intacct\Credentials\SenderCredentials::getSenderId
     * @covers Intacct\Credentials\SenderCredentials::getPassword
     * @covers Intacct\Credentials\SenderCredentials::getEndpoint
     */
    public function testCredsFromArray()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'endpoint_url' => 'https://unittest.intacct.com/ia/xmlgw.phtml',
        ];
        $creds = new SenderCredentials($config);
        
        $this->assertEquals('testsenderid', $creds->getSenderId());
        $this->assertEquals('pass123!', $creds->getPassword());
        $this->assertEquals('https://unittest.intacct.com/ia/xmlgw.phtml', $creds->getEndpoint());
    }

    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @covers Intacct\Credentials\SenderCredentials::getSenderId
     * @covers Intacct\Credentials\SenderCredentials::getPassword
     * @covers Intacct\Credentials\SenderCredentials::getEndpoint
     */
    public function testCredsFromEnv()
    {
        putenv('INTACCT_SENDER_ID=envsender');
        putenv('INTACCT_SENDER_PASSWORD=envpass');

        $creds = new SenderCredentials();

        $this->assertEquals('envsender', $creds->getSenderId());
        $this->assertEquals('envpass', $creds->getPassword());
        //TODO fix this -- $this->assertEquals('https://api.intacct.com/ia/xmlgw.phtml', $creds->getEndpoint());
        
        putenv('INTACCT_SENDER_ID');
        putenv('INTACCT_SENDER_PASSWORD');
    }
    
    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Required "sender_id" key not supplied in params or env variable "INTACCT_SENDER_ID"
     */
    public function testCredsNoSenderId()
    {
        $config = [
            //'sender_id' => null,
            'sender_password' => 'pass123!',
        ];
        $creds = new SenderCredentials($config);
    }
    
    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Required "sender_password" key not supplied in params or env variable "INTACCT_SENDER_PASSWORD"
     */
    public function testCredsNoSenderPassword()
    {
        $config = [
            'sender_id' => 'testsenderid',
            //'sender_password' => null,
        ];
        $creds = new SenderCredentials($config);
    }

}
