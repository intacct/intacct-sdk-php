<?php

/**
 * Copyright 2017 Intacct Corporation.
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

namespace Intacct\Xml;

use Intacct\Content;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Intacct\Functions\ApiSessionCreate;
use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @coversDefaultClass \Intacct\Xml\RequestHandler
 */
class RequestHandlerTest extends \PHPUnit_Framework_TestCase
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

    public function testGetVerifySSL()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'verify_ssl' => false,
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config, $requestBlock);
        
        $this->assertEquals($requestHandler->getVerifySSL(), false);
    }
    
    public function testSetMaxRetries()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => 10,
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config, $requestBlock);
        
        $this->assertEquals($requestHandler->getMaxRetries(), 10);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Requested encoding is not supported
     */
    public function testInvalidEncoding()
    {
        $config = [
            'encoding' => 'invalid',
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage max retries not valid int type
     */
    public function testSetMaxRetriesInvalidType()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => '10',
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage max retries must be zero or greater
     */
    public function testSetMaxRetriesInvalidInt()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => -1,
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }

    public function testSetNoRetryServerErrorCodes()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                502,
                524,
            ],
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config, $requestBlock);
        $expected = [
            502,
            524,
        ];
        $this->assertEquals($requestHandler->getNoRetryServerErrorCodes(), $expected);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage no retry server error code is not valid int type
     */
    public function testSetNoRetryServerErrorCodesInvalidInt()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                '500',
                '524',
            ],
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage no retry server error code must be between 500-599
     */
    public function testSetNoRetryServerErrorCodesInvalidRange()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                200,
            ],
        ];

        $contentBlock = new Content();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }

    public function testMockExecuteSynchronous()
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
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $response = $requestHandler->executeSynchronous($config, $contentBlock);

        $history = $requestHandler->getHistory();
        $xmlToTest = (string) $history[0]['response']->getBody();

        $this->assertXmlStringEqualsXmlString($xml, $xmlToTest);
        $this->assertInstanceOf(SynchronousResponse::class, $response);
    }

    public function testMockExecuteAsynchronous()
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
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'policy_id' => 'policyid321',
            'control_id' => 'requestUnitTest',
            'mock_handler' => $mock,
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $response = $requestHandler->executeAsynchronous($config, $contentBlock);

        $history = $requestHandler->getHistory();
        $xmlToTest = (string) $history[0]['response']->getBody();

        $this->assertXmlStringEqualsXmlString($xml, $xmlToTest);
        $this->assertInstanceOf(AsynchronousResponse::class, $response);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "policy_id" key not supplied in params for asynchronous request
     */
    public function testMockExecuteAsynchronousMissingPolicyId()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            //'policy_id' => 'policyid321',
            'control_id' => 'requestUnitTest',
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $response = $requestHandler->executeAsynchronous($config, $contentBlock);
    }

    public function testMockRetry()
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
        
        $mock = new MockHandler([
            new Response(502),
            new Response(200, $headers, $xml),
        ]);
        
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $requestHandler->executeSynchronous($config, $contentBlock);

        $history = $requestHandler->getHistory();
        $this->assertEquals(2, count($history));
        $this->assertEquals(502, $history[0]['response']->getStatusCode());
        $this->assertEquals(200, $history[1]['response']->getStatusCode());
    }
    
    /**
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testMockDefaultRetryFailure()
    {
        $mock = new MockHandler([
            new Response(500),
            new Response(501),
            new Response(502),
            new Response(504),
            new Response(505),
            new Response(506),
        ]);
        
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $requestHandler->executeSynchronous($config, $contentBlock);
    }
    
    /**
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testMockDefaultNo524Retry()
    {
        $mock = new MockHandler([
            new Response(524),
        ]);
        
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $requestHandler->executeSynchronous($config, $contentBlock);
    }

    public function testMockExecuteWithDebugLogger()
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

        $handle = fopen('php://memory', 'a+');
        $handler = new StreamHandler($handle, Logger::DEBUG);
        $logger = new Logger('unittest');
        $logger->pushHandler($handler);

        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
            'logger' => $logger,
        ];

        $contentBlock = new Content([
            new ApiSessionCreate(),
        ]);

        $requestHandler = new RequestHandler($config);
        $response = $requestHandler->executeSynchronous($config, $contentBlock);

        // Test for some output in the StreamHandler
        fseek($handle, 0);
        $this->assertEquals('[', substr(stream_get_contents($handle), 0, 1));
    }
}
