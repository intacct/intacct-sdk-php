<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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
use Intacct\Functions\Company\ApiSessionCreate;
use Intacct\Functions\Common\ReadByQuery;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @coversDefaultClass \Intacct\OnlineClient
 */
class OnlineClientTest extends \PHPUnit\Framework\TestCase
{

    public function testExecute(): void
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
                  <locationid></locationid>
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
        $clientConfig->setSenderId('testsender');
        $clientConfig->setSenderPassword('testsendpass');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $client = new OnlineClient($clientConfig);

        $response = $client->execute(new ApiSessionCreate('func1UnitTest'));

        $this->assertEquals('requestUnitTest', $response->getControl()->getControlId());
    }

    public function testExecuteResultException(): void
    {
        $this->expectException(\Intacct\Exception\ResultException::class);
        $this->expectExceptionMessage("Result status: failure for Control ID: func1UnitTest - Get API Session Failed Something went wrong");

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
                  <locationid></locationid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>failure</status>
                  <function>getAPISession</function>
                  <controlid>func1UnitTest</controlid>
                  <errormessage>
                        <error>
                              <errorno>Get API Session Failed</errorno>
                              <description></description>
                              <description2>Something went wrong</description2>
                              <correction></correction>
                        </error>
                  </errormessage>
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
        $clientConfig->setSenderId('testsender');
        $clientConfig->setSenderPassword('testsendpass');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $client = new OnlineClient($clientConfig);

        $response = $client->execute(new ApiSessionCreate('func1UnitTest'));
    }

    public function testExecuteBatchTransactionResultException(): void
    {
        $this->expectException(\Intacct\Exception\ResultException::class);
        $this->expectExceptionMessage("Result status: failure for Control ID: func2UnitTest - Get API Session Failed Something went wrong - XL03000009 The entire transaction in this operation has been rolled back due to an error.");

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
                  <locationid></locationid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>aborted</status>
                  <function>getAPISession</function>
                  <controlid>func1UnitTest</controlid>
                  <errormessage>
                          <error>
                                <errorno>XL03000009</errorno>
                                <description></description>
                                <description2>The entire transaction in this operation has been rolled back due to an error.</description2>
                                <correction></correction>
                          </error>
                  </errormessage>
            </result>
            <result>
                  <status>failure</status>
                  <function>getAPISession</function>
                  <controlid>func2UnitTest</controlid>
                  <errormessage>
                        <error>
                              <errorno>Get API Session Failed</errorno>
                              <description></description>
                              <description2>Something went wrong</description2>
                              <correction></correction>
                        </error>
                          <error>
                                <errorno>XL03000009</errorno>
                                <description></description>
                                <description2>The entire transaction in this operation has been rolled back due to an error.</description2>
                                <correction></correction>
                          </error>
                  </errormessage>
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
        $clientConfig->setSenderId('testsender');
        $clientConfig->setSenderPassword('testsendpass');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);

        $client = new OnlineClient($clientConfig);

        $requestConfig = new RequestConfig();
        $requestConfig->setTransaction(true);

        $response = $client->executeBatch([
            new ApiSessionCreate('func1UnitTest'),
            new ApiSessionCreate('func2UnitTest')
        ], $requestConfig);
    }

    public function testLogger(): void
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
                  <locationid></locationid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                <status>success</status>
                <function>readByQuery</function>
                <controlid>func1UnitTest</controlid>
                <data listtype="customer" count="1" totalcount="1" numremaining="0" resultId="">
                    <customer>
                        <CUSTOMERID>C0001</CUSTOMERID>
                        <NAME>Sage Intacct, Inc</NAME>
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

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsender');
        $clientConfig->setSenderPassword('testsendpass');
        $clientConfig->setSessionId('testsession..');
        $clientConfig->setMockHandler($mock);
        $clientConfig->setLogger($logger);

        $client = new OnlineClient($clientConfig);

        $response = $client->execute(new ReadByQuery('func1UnitTest'));

        fseek($handle, 0);
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);

        $this->assertStringContainsString('<password>REDACTED</password>', $contents);
    }
}
