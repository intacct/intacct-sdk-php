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

namespace Intacct\Logging;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Intacct\ClientConfig;
use Intacct\Functions\Company\ApiSessionCreate;
use Intacct\RequestConfig;
use Intacct\Xml\RequestBlock;

/**
 * @coversDefaultClass \Intacct\Logging\MessageFormatter
 */
class MessageFormatterTest extends \PHPUnit\Framework\TestCase
{

    public function testRequestAndResponseRemoval()
    {
        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');
        $clientConfig->setCompanyId('testcompany');
        $clientConfig->setUserId('testuser');
        $clientConfig->setUserPassword('P@ssW0rd!123');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('unittest');

        $contentBlock = [
            new ApiSessionCreate('test1'),
        ];
        $xmlRequest = new RequestBlock($clientConfig, $requestConfig, $contentBlock);

        $xmlResponse = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <control>
        <status>success</status>
        <senderid>testsenderid</senderid>
        <controlid>unittest</controlid>
        <uniqueid>false</uniqueid>
        <dtdversion>3.0</dtdversion>
    </control>
    <operation>
        <authentication>
            <status>success</status>
            <userid>testuser</userid>
            <companyid>testcompany</companyid>
            <sessiontimestamp>2016-08-22T10:58:43-07:00</sessiontimestamp>
        </authentication>
        <result>
              <status>success</status>
              <function>test1</function>
              <controlid>testControlId</controlid>
              <data>
                    <api>
                          <sessionid>fAkESesSiOnId..</sessionid>
                          <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                    </api>
              </data>
        </result>
        <result>
            <status>success</status>
            <function>get_list</function>
            <controlid>test2</controlid>
            <listtype start="0" end="0" total="1">vendor</listtype>
            <data>
                <vendor>
                    <recordno>4</recordno>
                    <vendorid>V0004</vendorid>
                    <name>Vendor 4</name>
                    <taxid>99-9999999</taxid>
                    <achenabled>true</achenabled>
                    <achaccountnumber>1111222233334444</achaccountnumber>
                    <achaccounttype>Checking Account</achaccounttype>
                </vendor>
            </data>
        </result>
        <result>
            <status>success</status>
            <function>readByQuery</function>
            <controlid>test3</controlid>
            <data listtype="vendor" count="1" totalcount="1" numremaining="0" resultId="">
                <vendor>
                    <RECORDNO>4</RECORDNO>
                    <VENDORID>V0004</VENDORID>
                    <NAME>Vendor 4</NAME>
                    <TAXID>99-9999999</TAXID>
                    <ACHENABLED>true</ACHENABLED>
                    <ACHACCOUNTNUMBER>1111222233334444</ACHACCOUNTNUMBER>
                    <ACHACCOUNTTYPE>Checking Account</ACHACCOUNTTYPE>
                </vendor>
            </data>
        </result>
    </operation>
</response>
EOF;

        $mockRequest = new Request('POST', 'https://unittest.intacct.com', [], $xmlRequest->writeXml()->flush());
        $mockResponse = new Response(200, [], $xmlResponse);

        $formatter = new MessageFormatter("{req_body}/n/r{res_body}");
        $message = $formatter->format($mockRequest, $mockResponse);

        $this->assertStringNotContainsString('<password>pass123!</password>', $message);
        $this->assertStringNotContainsString('<password>P@ssW0rd!123</password>', $message);
        $this->assertStringContainsString('<password>REDACTED</password>', $message);

        $this->assertStringNotContainsString('<sessionid>fAkESesSiOnId..</sessionid>', $message);
        $this->assertStringContainsString('<sessionid>REDACTED</sessionid>', $message);

        $this->assertStringNotContainsString('<taxid>99-9999999</taxid>', $message);
        $this->assertStringNotContainsString('<TAXID>99-9999999</TAXID>', $message);
        $this->assertStringContainsString('<taxid>REDACTED</taxid>', $message);
        $this->assertStringContainsString('<TAXID>REDACTED</TAXID>', $message);

        $this->assertStringNotContainsString('<achaccountnumber>1111222233334444</achaccountnumber>', $message);
        $this->assertStringNotContainsString('<ACHACCOUNTNUMBER>1111222233334444</ACHACCOUNTNUMBER>', $message);
        $this->assertStringContainsString('<achaccountnumber>REDACTED</achaccountnumber>', $message);
        $this->assertStringContainsString('<ACHACCOUNTNUMBER>REDACTED</ACHACCOUNTNUMBER>', $message);
    }
}
