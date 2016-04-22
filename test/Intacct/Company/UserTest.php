<?php

/*
 * Copyright 2016 Intacct Corporation.
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

class UserTest extends  \PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var User
     */
    private $user;

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

        $client = new IntacctClient([
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
            'mock_handler' => $mock,
        ]);
        $this->user = $client->Company()->User();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers Intacct\User::getUserPermissions
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     */
    public function testGetUserPermissionsSuccess()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>requestControlId</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>testuser</userid>
                  <companyid>testcompany</companyid>
                  <sessiontimestamp>2016-01-24T14:26:56-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getUserPermissions</function>
                  <controlid>getUserPermissions</controlid>
                  <data><permissions><appSubscription><applicationName>Time </applicationName><policies><policy><policyName>My Expenses</policyName><rights>List|View|Add|Edit|Delete</rights></policy><policy><policyName>Expense Adjustments</policyName><rights>List|View|Add|Edit|Delete|Reverse|Reclass</rights></policy><policy><policyName>Approve Expenses</policyName><rights>List</rights></policy></policies></appSubscription></permissions>                  </data>
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
            'user_id' => 'testuser',
            'mock_handler' => $mock,
        ];
        $permissions = $this->user->getUserPermissions($config);
        $this->assertEquals($permissions->getStatus(), 'success');
        $this->assertEquals($permissions->getFunction(), 'getUserPermissions');
        $this->assertEquals($permissions->getControlId(), 'getUserPermissions');
    }

    /**
     * @covers Intacct\User::getUserPermissions
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to get user permissions
     */
    public function testGetUserPermissionsFailure()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>requestControlId</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>testuser</userid>
                  <companyid>testcompany</companyid>
                  <sessiontimestamp>2016-01-24T14:26:56-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>failure</status>
                  <function>getUserPermissions</function>
                  <controlid>getUserPermissions</controlid>
                  <errormessage>
                        <error>
                              <errorno>BL03000025</errorno>
                              <description></description>
                              <description2>Login ID unittest does not exist.</description2>
                              <correction>Provide a valid USER.LOGINID value.</correction>
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

        $config = [
            'user_id' => 'unittest',
            'mock_handler' => $mock,
        ];
        $this->user->getUserPermissions($config);
    }

}