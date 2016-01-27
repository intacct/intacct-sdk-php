<?php

namespace Intacct\Credentials;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class SessionCredentialsTest extends \PHPUnit_Framework_TestCase
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
            'sender_id' => 'testsenderid',
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
     * @covers Intacct\Credentials\SessionCredentials::__construct
     * @covers Intacct\Credentials\SessionCredentials::getSessionId
     * @covers Intacct\Credentials\SessionCredentials::getEndpoint
     * @covers Intacct\Credentials\SessionCredentials::getSenderCredentials
     */
    public function testCredsFromArray()
    {
        $config = [
            'session_id' => 'faKEsesSiOnId..',
            'endpoint_url' => 'https://p1.intacct.com/ia/xml/xmlgw.phtml',
        ];
        $sessionCreds = new SessionCredentials($config, $this->senderCreds);

        $this->assertEquals('faKEsesSiOnId..', $sessionCreds->getSessionId());
        $endpoint = $sessionCreds->getEndpoint();
        $this->assertEquals('https://p1.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
        $this->assertThat($sessionCreds->getSenderCredentials(), $this->isInstanceOf('Intacct\Credentials\SenderCredentials'));
    }
    
    /**
     * @covers Intacct\Credentials\SessionCredentials::__construct
     * @covers Intacct\Credentials\SessionCredentials::getEndpoint
     */
    public function testCredsFromArrayNoEndpoint()
    {
        $config = [
            'session_id' => 'faKEsesSiOnId..',
            'endpoint_url' => null,
        ];
        $sessionCreds = new SessionCredentials($config, $this->senderCreds);

        $endpoint = $sessionCreds->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
    }
    
    /**
     * @covers Intacct\Credentials\SessionCredentials::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "session_id" key not supplied in params
     */
    public function testCredsFromArrayNoSession()
    {
        $config = [
            'session_id' => null,
        ];
        $sessionCreds = new SessionCredentials($config, $this->senderCreds);
    }
    
    /**
     * @covers Intacct\Credentials\SessionCredentials::__construct
     * @covers Intacct\Credentials\SessionCredentials::getMockHandler
     */
    public function testGetMockHandler()
    {
        $response = new Response(200);
        $mock = new MockHandler([
            $response,
        ]);
        $config = [
            'session_id' => 'faKEsesSiOnId..',
            'endpoint_url' => 'https://p1.intacct.com/ia/xml/xmlgw.phtml',
            'mock_handler' => $mock,
        ];
        $sessionCreds = new SessionCredentials($config, $this->senderCreds);
        $this->assertThat($sessionCreds->getMockHandler(), $this->isInstanceOf('GuzzleHttp\Handler\MockHandler'));
    }

}
