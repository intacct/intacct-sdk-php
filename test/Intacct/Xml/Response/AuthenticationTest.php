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

namespace Intacct\Xml\Response;

use Intacct\Xml\OnlineResponse;

/**
 * @coversDefaultClass \Intacct\Xml\Response\Authentication
 */
class AuthenticationTest extends \PHPUnit\Framework\TestCase
{

    public function testAuthenticationResponse(): void
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
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
                  <sessiontimeout>2015-12-07T15:57:08-08:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>faKEsesSiOnId..</sessionid>
                              <endpoint>https://api.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                              <locationid></locationid>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $response = new OnlineResponse($xml);

        $authentication = $response->getAuthentication();

        $this->assertEquals('success', $authentication->getStatus());
        $this->assertEquals('fakeuser', $authentication->getUserId());
        $this->assertEquals('fakecompany', $authentication->getCompanyId());
        $this->assertEquals('', $authentication->getEntityId());
        $this->assertEquals('2015-10-24T18:56:52-07:00', $authentication->getSessionTimestamp());
        $this->assertEquals('2015-12-07T15:57:08-08:00', $authentication->getSessionTimeout());
    }

    public function testMissingStatusElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Authentication block is missing status element");

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
                  <!--<status>success</status>-->
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <locationid></locationid>
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-25T18:56:52-07:00</sessiontimeout>
            </authentication>
            <result/>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testMissingUserIdElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Authentication block is missing userid element");

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
                  <!--<userid>fakeuser</userid>-->
                  <companyid>fakecompany</companyid>
                  <locationid></locationid>
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-25T18:56:52-07:00</sessiontimeout>
            </authentication>
            <result/>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testMissingCompanyIdElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Authentication block is missing companyid element");

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
                  <!--<companyid>fakecompany</companyid>-->
                  <locationid></locationid>
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
                  <sessiontimestamp>2015-10-25T18:56:52-07:00</sessiontimestamp>
            </authentication>
            <result/>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }
}
