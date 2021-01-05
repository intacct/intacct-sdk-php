<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Intacct\ClientConfig;
use Intacct\Exception\ResponseException;
use Intacct\Functions\Company\ApiSessionCreate;
use Intacct\RequestConfig;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @coversDefaultClass \Intacct\Xml\RequestHandler
 */
class RequestHandlerTest extends \PHPUnit\Framework\TestCase
{

    public function testMockExecuteOnline(): void
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
                  <locationid></locationid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
                  <sessiontimeout>2015-12-07T15:57:08-08:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>func1UnitTest</controlid>
                  <data>
                        <api>
                              <sessionid>unittest..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                              <locationid></locationid>
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

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('unittest');

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $response = $requestHandler->executeOnline($contentBlock);

        $this->assertInstanceOf(OnlineResponse::class, $response);
    }

    public function testMockExecuteAsynchronous(): void
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

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setCompanyId('testcompany');
        $clientConfig->setUserId('testuser');
        $clientConfig->setUserPassword('testpass');
        $clientConfig->setMockHandler($mock);

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('requestUnitTest');
        $requestConfig->setPolicyId('policyid123');

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $response = $requestHandler->executeOffline($contentBlock);

        $this->assertInstanceOf(OfflineResponse::class, $response);
    }

    public function testMockExecuteAsynchronousMissingPolicyId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Required Policy ID not supplied in config for offline request");

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('requestUnitTest');
        //$requestConfig->setPolicyId('policyid123');

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $response = $requestHandler->executeOffline($contentBlock);
    }

    public function testMockRetry(): void
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
                  <locationid></locationid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
                  <sessiontimeout>2015-12-07T15:57:08-08:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>func1UnitTest</controlid>
                  <data>
                        <api>
                              <sessionid>unittest..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                              <locationid></locationid>
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

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $requestConfig = new RequestConfig();

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $requestHandler->executeOnline($contentBlock);

        $history = $requestHandler->getHistory();
        $this->assertEquals(2, count($history));
        $this->assertEquals(502, $history[0]['response']->getStatusCode());
        $this->assertEquals(200, $history[1]['response']->getStatusCode());
    }

    public function testMock400LevelErrorWithXmlResponse(): void
    {
        $this->expectException(\Intacct\Exception\ResponseException::class);

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <control>
        <status>failure</status>
    </control>
    <errormessage>
        <error>
            <errorno>XMLGW_JPP0002</errorno>
            <description>Sign-in information is incorrect. Please check your request.</description>
        </error>
    </errormessage>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];

        $mock = new MockHandler([
            new Response(401, $headers, $xml),
        ]);

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setCompanyId('badcompany');
        $clientConfig->setUserId('baduser');
        $clientConfig->setUserPassword('badpass');
        $clientConfig->setMockHandler($mock);

        $requestConfig = new RequestConfig();

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $requestHandler->executeOnline($contentBlock);
    }

    public function testMockDefaultRetryFailure(): void
    {
        $this->expectException(\GuzzleHttp\Exception\ServerException::class);

        $mock = new MockHandler([
            new Response(500),
            new Response(501),
            new Response(502),
            new Response(504),
            new Response(505),
            new Response(506),
        ]);

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $requestConfig = new RequestConfig();

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $requestHandler->executeOnline($contentBlock);
    }

    public function testMockDefaultNo524Retry(): void
    {
        $this->expectException(\GuzzleHttp\Exception\ServerException::class);

        $mock = new MockHandler([
            new Response(524),
        ]);

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $requestConfig = new RequestConfig();

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $requestHandler->executeOnline($contentBlock);
    }

    public function testMockExecuteWithDebugLogger(): void
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
                  <locationid></locationid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
                  <sessiontimeout>2015-12-07T15:57:08-08:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>func1UnitTest</controlid>
                  <data>
                        <api>
                              <sessionid>unittest..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                              <locationid></locationid>
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

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);
        $clientConfig->setLogger($logger);

        $requestConfig = new RequestConfig();

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $response = $requestHandler->executeOnline($contentBlock);

        // Test for some output in the StreamHandler
        fseek($handle, 0);
        $this->assertEquals('[', substr(stream_get_contents($handle), 0, 1));
    }

    public function testMockExecuteOfflineWithSessionCreds(): void
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

        $handle = fopen('php://memory', 'a+');
        $handler = new StreamHandler($handle, Logger::WARNING);
        $logger = new Logger('unittest');
        $logger->pushHandler($handler);

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);
        $clientConfig->setLogger($logger);

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('requestUnitTest');
        $requestConfig->setPolicyId('policyid123');

        $contentBlock = [
            new ApiSessionCreate(),
        ];

        $requestHandler = new RequestHandler($clientConfig, $requestConfig);
        $response = $requestHandler->executeOffline($contentBlock);

        // Test for some output in the StreamHandler
        fseek($handle, 0);
        $this->assertStringContainsString(
            'Offline execution sent to Sage Intacct using Session-based credentials.',
            stream_get_contents($handle)
        );
    }
}
