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

namespace Intacct\Logging;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Intacct\Content;
use Intacct\Functions\ApiSessionCreate;
use Intacct\Xml\RequestBlock;

/**
 * @coversDefaultClass \Intacct\Logging\MessageFormatter
 */
class MessageFormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testRequestAndResponseRemoval()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'P@ssW0rd!123',
        ];
        $contentBlock = new Content([
            new ApiSessionCreate('unittest'),
        ]);
        $xmlRequest = new RequestBlock($config, $contentBlock);

        $xmlResponse = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <control>
        <status>success</status>
        <senderid>testsenderid</senderid>
        <controlid>testControl</controlid>
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
            <function>get_list</function>
            <controlid>test1</controlid>
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
            <controlid>test2</controlid>
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

        $this->assertNotContains('<password>pass123!</password>', $message);
        $this->assertNotContains('<password>P@ssW0rd!123</password>', $message);
        $this->assertContains('<password>REDACTED</password>', $message);

        $this->assertNotContains('<taxid>99-9999999</taxid>', $message);
        $this->assertNotContains('<TAXID>99-9999999</TAXID>', $message);
        $this->assertContains('<taxid>REDACTED</taxid>', $message);
        $this->assertContains('<TAXID>REDACTED</TAXID>', $message);

        $this->assertNotContains('<achaccountnumber>1111222233334444</achaccountnumber>', $message);
        $this->assertNotContains('<ACHACCOUNTNUMBER>1111222233334444</ACHACCOUNTNUMBER>', $message);
        $this->assertContains('<achaccountnumber>REDACTED</achaccountnumber>', $message);
        $this->assertContains('<ACHACCOUNTNUMBER>REDACTED</ACHACCOUNTNUMBER>', $message);
    }
}
