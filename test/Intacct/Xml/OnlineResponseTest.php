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

/**
 * @coversDefaultClass \Intacct\Xml\OnlineResponse
 */
class OnlineResponseTest extends \PHPUnit\Framework\TestCase
{

    public function testGetters(): void
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <locationid></locationid>
                  <sessiontimestamp>2015-10-22T20:58:27-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-23T20:58:27-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>fAkESesSiOnId..</sessionid>
                              <endpoint>https://api.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                              <locationid></locationid>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;

        $response = new OnlineResponse($xml);
        $this->assertIsArray($response->getResults());
    }

    public function testMissingOperationBlock(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Response is missing operation block");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testAuthenticationFailure(): void
    {
        $this->expectException(\Intacct\Exception\ResponseException::class);
        $this->expectExceptionMessage("Response authentication status failure - XL03000006 Sign-in information is incorrect");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>failure</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <locationid></locationid>
            </authentication>
            <errormessage>
                  <error>
                        <errorno>XL03000006</errorno>
                        <description></description>
                        <description2>Sign-in information is incorrect</description2>
                        <correction></correction>
                  </error>
            </errormessage>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testMissingAuthenticationBlock(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Authentication block is missing from operation element");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation/>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testMissingResultBlock(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Result block is missing from operation element");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <locationid></locationid>
                  <sessiontimestamp>2015-10-22T20:58:27-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-23T20:58:27-07:00</sessiontimeout>
            </authentication>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testResponseExceptionWithErrors(): void
    {
        $this->expectException(\Intacct\Exception\ResponseException::class);
        $this->expectExceptionMessage("Response control status failure - PL04000055 This company is a demo company and has expired.");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <control>
        <status>failure</status>
        <senderid></senderid>
        <controlid></controlid>
    </control>
    <errormessage>
        <error>
            <errorno>PL04000055</errorno>
            <description></description>
            <description2>This company is a demo company and has expired.</description2>
            <correction></correction>
        </error>
    </errormessage>
</response>
EOF;
        new OnlineResponse($xml);
    }
}
