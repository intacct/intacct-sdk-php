<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

namespace Intacct;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Intacct\Functions\ApiSessionCreate;
use Intacct\Functions\Common\ReadByQuery;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @coversDefaultClass \Intacct\IntacctClient
 */
class IntacctClientTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var IntacctClient
     */
    private $client;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        //the IntacctClient constructor will always get a session id, so mock it
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
                  <function>getAPISession</function>
                  <controlid>getSession</controlid>
                  <data>
                        <api>
                              <sessionid>testSeSsionID..</sessionid>
                              <endpoint>https://p1.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);
        
        $this->client = new IntacctClient([
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
            'mock_handler' => $mock,
        ]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testConstructWithSessionId()
    {
        $client = $this->client; //grab the setUp object

        $creds = $client->getSessionCreds();
        $this->assertEquals($creds->getEndpoint(), 'https://p1.intacct.com/ia/xml/xmlgw.phtml');
        $this->assertEquals($creds->getSessionId(), 'testSeSsionID..');
        $this->assertEquals($creds->getCurrentCompanyId(), 'testcompany');
        $this->assertEquals($creds->getCurrentUserId(), 'testuser');
        $this->assertEquals($creds->getCurrentUserIsExternal(), false);
    }
    
    public function testConstructWithLogin()
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
                  <function>getAPISession</function>
                  <controlid>getSession</controlid>
                  <data>
                        <api>
                              <sessionid>helloworld..</sessionid>
                              <endpoint>https://p1.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);
        
        $client = new IntacctClient([
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'originalSeSsIonID..',
            'mock_handler' => $mock,
        ]);
        
        $creds = $client->getSessionCreds();
        $this->assertEquals($creds->getEndpoint(), 'https://p1.intacct.com/ia/xml/xmlgw.phtml');
        $this->assertEquals($creds->getSessionId(), 'helloworld..');
        $this->assertEquals($creds->getCurrentCompanyId(), 'testcompany');
        $this->assertEquals($creds->getCurrentUserId(), 'testuser');
        $this->assertEquals($creds->getCurrentUserIsExternal(), false);
    }

    public function testExecuteSynchronous()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>requestUnitTest</controlid>
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
                  <function>getAPISession</function>
                  <controlid>func1UnitTest</controlid>
                  <data>
                        <api>
                              <sessionid>unittest..</sessionid>
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
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);

        $config = [
            'mock_handler' => $mock, //put a new handler on here
        ];

        $content = new Content([
            new ApiSessionCreate('func1UnitTest')
        ]);

        $client = $this->client; //grab the setUp object

        $response = $client->execute($content, false, 'requestUnitTest', false, $config);

        $this->assertEquals('requestUnitTest', $response->getControl()->getControlId());
    }

    public function testExecuteAsynchronous()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <acknowledgement>
            <status>success</status>
      </acknowledgement>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>requestUnitTest</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);

        $config = [
            'mock_handler' => $mock, //put a new handler on here
        ];

        $content = new Content([
            new ApiSessionCreate('func1UnitTest')
        ]);

        $client = $this->client; //grab the setUp object

        $response = $client->executeAsync($content, 'asyncPolicyId', false, 'requestUnitTest', false, $config);

        $this->assertEquals('requestUnitTest', $response->getControl()->getControlId());
    }

    public function testRandomControlId()
    {
        $controlId = $this->client->generateRandomControlId();
        $this->assertInternalType('string', $controlId);
        $this->assertContains('-', $controlId);
    }

    public function testLogger()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>requestUnitTest</controlid>
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
                <function>readByQuery</function>
                <controlid>func1UnitTest</controlid>
                <data listtype="customer" count="1" totalcount="1" numremaining="0" resultId="">
                    <customer>
                        <CUSTOMERID>C0001</CUSTOMERID>
                        <NAME>Saas Corporation</NAME>
                    </customer>
                </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);

        $handle = fopen('php://memory', 'a+');
        $handler = new StreamHandler($handle);

        $logger = new Logger('unittest');
        $logger->pushHandler($handler);

        $config = [
            'mock_handler' => $mock, //put a new handler on here
            'logger' => $logger,
        ];

        $content = new Content([
            new ReadByQuery('func1UnitTest')
        ]);

        $client = $this->client; //grab the setUp object

        $response = $client->execute($content, false, 'requestUnitTest', false, $config);

        fseek($handle, 0);
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);

        $this->assertContains('<password>REDACTED</password>', $contents);
    }
}
