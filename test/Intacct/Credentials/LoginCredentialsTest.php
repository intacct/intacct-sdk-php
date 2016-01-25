<?php

namespace Intacct\Credentials;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class LoginCredentialsTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var SenderCredentials
     */
    protected $senderCreds;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
        ];
        $this->senderCreds = new SenderCredentials($config);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }
    
    /**
     * @covers Intacct\Credentials\LoginCredentials::__construct
     * @covers Intacct\Credentials\LoginCredentials::getCompanyId
     * @covers Intacct\Credentials\LoginCredentials::getUserId
     * @covers Intacct\Credentials\LoginCredentials::getPassword
     * @covers Intacct\Credentials\LoginCredentials::getSenderCredentials
     * @covers Intacct\Credentials\LoginCredentials::getEndpoint
     */
    public function testCredsFromArray()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('testcompany', $loginCreds->getCompanyId());
        $this->assertEquals('testuser', $loginCreds->getUserId());
        $this->assertEquals('testpass', $loginCreds->getPassword());
        $endpoint = $loginCreds->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertThat($loginCreds->getSenderCredentials(), $this->isInstanceOf('Intacct\Credentials\SenderCredentials'));
    }
    
    /**
     * 
     * @todo   Implement testCredsFromProfile().
     */
    public function testCredsFromProfile()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    /**
     * @covers Intacct\Credentials\LoginCredentials::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "company_id" key not supplied in params or env variable "INTACCT_COMPANY_ID"
     */
    public function testCredsFromArrayNoCompanyId()
    {
        $config = [
            'company_id' => null,
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @covers Intacct\Credentials\LoginCredentials::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_id" key not supplied in params or env variable "INTACCT_USER_ID"
     */
    public function testCredsFromArrayNoUserId()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => null,
            'user_password' => 'testpass',
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @covers Intacct\Credentials\LoginCredentials::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_password" key not supplied in params or env variable "INTACCT_USER_PASSWORD"
     */
    public function testCredsFromArrayNoUserPassword()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => null,
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @covers Intacct\Credentials\LoginCredentials::__construct
     * @covers Intacct\Credentials\LoginCredentials::getMockHandler
     */
    public function testGetMockHandler()
    {
        $response = new Response(200);
        $mock = new MockHandler([
            $response,
        ]);
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
            'mock_handler' => $mock,
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);
        $this->assertThat($loginCreds->getMockHandler(), $this->isInstanceOf('GuzzleHttp\Handler\MockHandler'));
    }

}
