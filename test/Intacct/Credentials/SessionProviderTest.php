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

namespace Intacct\Credentials;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class SessionProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SessionProvider
     */
    protected $object;
    
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
        $this->object = new SessionProvider();
        
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'verify_ssl' => false,
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
     * @covers Intacct\Credentials\SessionProvider::__construct
     * @covers Intacct\Credentials\SessionProvider::fromLoginCredentials
     * @covers Intacct\Credentials\SessionProvider::getAPISession
     * @covers Intacct\Credentials\SessionProvider::getConfig
     */
    public function testFromLoginCredentials()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>sessionProvider</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>testuser</userid>
                  <companyid>testcompany</companyid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getSession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>fAkESesSiOnId..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $response = new Response(200, $headers, $xml);
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
        
        $sessionCreds = $this->object->fromLoginCredentials($loginCreds);
        
        $this->assertEquals('fAkESesSiOnId..', $sessionCreds->getSessionId());
        $endpoint = $sessionCreds->getEndpoint();
        $this->assertEquals('https://unittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
        $this->assertThat($sessionCreds->getSenderCredentials(), $this->isInstanceOf('Intacct\Credentials\SenderCredentials'));
    }
    
    /**
     * @covers Intacct\Credentials\SessionProvider::__construct
     * @covers Intacct\Credentials\SessionProvider::fromSessionCredentials
     * @covers Intacct\Credentials\SessionProvider::getAPISession
     * @covers Intacct\Credentials\SessionProvider::getConfig
     */
    public function testFromSessionCredentials()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>sessionProvider</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>testuser</userid>
                  <companyid>testcompany</companyid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getSession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>fAkESesSiOnId..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $response = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $response,
        ]);
        $config = [
            'session_id' => 'fAkESesSiOnId..',
            'endpoint_url' => 'https://unittest.intacct.com/ia/xml/xmlgw.phtml',
            'mock_handler' => $mock,
        ];
        $sessionCreds = new SessionCredentials($config, $this->senderCreds);
        
        $newSessionCreds = $this->object->fromSessionCredentials($sessionCreds);
        
        $this->assertEquals('fAkESesSiOnId..', $newSessionCreds->getSessionId());
        $endpoint = $newSessionCreds->getEndpoint();
        $this->assertEquals('https://unittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
        $this->assertThat($newSessionCreds->getSenderCredentials(), $this->isInstanceOf('Intacct\Credentials\SenderCredentials'));
    }

}
