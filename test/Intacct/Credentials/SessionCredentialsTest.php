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

namespace Intacct\Credentials;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Credentials\SessionCredentials
 */
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
        $this->assertThat(
            $sessionCreds->getSenderCredentials(),
            $this->isInstanceOf('Intacct\Credentials\SenderCredentials')
        );
    }

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
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "session_id" key not supplied in params
     */
    public function testCredsFromArrayNoSession()
    {
        $config = [
            'session_id' => null,
        ];
        new SessionCredentials($config, $this->senderCreds);
    }

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
