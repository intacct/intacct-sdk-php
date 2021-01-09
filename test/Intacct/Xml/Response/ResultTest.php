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
 * @coversDefaultClass \Intacct\Xml\Response\Operation\Result
 */
class ResultTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Result
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp(): void
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>readByQuery</function>
                  <controlid>testControlId</controlid>
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        $response = new OnlineResponse($xml);
        $this->object = $response->getResult();
    }

    public function testConstruct(): void
    {
        $this->assertThat($this->object, $this->isInstanceOf('Intacct\Xml\Response\Result'));
    }

    public function testGetStatus(): void
    {
        $this->assertEquals('success', $this->object->getStatus());
    }

    public function testGetFunction(): void
    {
        $this->assertEquals('readByQuery', $this->object->getFunction());
    }

    public function testGetControlId(): void
    {
        $this->assertEquals('testControlId', $this->object->getControlId());
    }

    public function testGetData(): void
    {
        $this->assertCount(0, $this->object->getData());
    }

    public function testGetErrors(): void
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
                  <sessiontimestamp>2015-10-25T11:07:22-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>failure</status>
                  <function>readByQuery</function>
                  <controlid>testControlId</controlid>
                  <errormessage>
                        <error>
                              <errorno>Query Failed</errorno>
                              <description></description>
                              <description2>Object definition BADOBJECT not found</description2>
                              <correction></correction>
                        </error>
                  </errormessage>
            </result>
      </operation>
</response>
EOF;
        $response = new OnlineResponse($xml);
        $results = $response->getResults();
        $result = $results[0];

        $this->assertEquals('failure', $result->getStatus());
        $this->assertIsArray($result->getErrors());
    }

    public function testMissingStatusElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Result block is missing status element");

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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <!--<status>success</status>-->
                  <function>readByQuery</function>
                  <controlid>testControlId</controlid>
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testMissingFunctionElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Result block is missing function element");

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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <!--<function>readByQuery</function>-->
                  <controlid>testControlId</controlid>
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testMissingControlIdElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Result block is missing controlid element");

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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>success</status>
                  <function>readByQuery</function>
                  <!--<controlid>testControlId</controlid>-->
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        new OnlineResponse($xml);
    }

    public function testStatusFailure()
    {
        $this->expectException(\Intacct\Exception\ResultException::class);
        $this->expectExceptionMessage("Result status: failure for Control ID: testFunctionId - XXX Object definition VENDOR2 not found");

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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>failure</status>
                  <function>read</function>
                  <controlid>testFunctionId</controlid>
                  <errormessage>
                        <error>
                              <errorno>XXX</errorno>
                              <description></description>
                              <description2>Object definition VENDOR2 not found</description2>
                              <correction></correction>
                        </error>
                  </errormessage>
            </result>
      </operation>
</response>
EOF;
        $response = new OnlineResponse($xml);

        $results = $response->getResults();

        $results[0]->ensureStatusNotFailure();
    }

    public function testStatusAbort(): void
    {
        $this->expectException(\Intacct\Exception\ResultException::class);
        $this->expectExceptionMessage("Result status: aborted for Control ID: testFunctionId - Query Failed Object definition VENDOR9 not found - XL03000009 The entire transaction in this operation has been rolled back due to an error.");

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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>aborted</status>
                  <function>readByQuery</function>
                  <controlid>testFunctionId</controlid>
                  <errormessage>
                          <error>
                                <errorno>Query Failed</errorno>
                                <description></description>
                                <description2>Object definition VENDOR9 not found</description2>
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
        $response = new OnlineResponse($xml);

        $results = $response->getResults();

        $results[0]->ensureStatusSuccess();
    }

    /**
     * Test no exception is thrown even though the status is aborted
     */
    public function testStatusNotFailureOnAborted(): void
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                  <status>aborted</status>
                  <function>readByQuery</function>
                  <controlid>testFunctionId</controlid>
                  <errormessage>
                          <error>
                                <errorno>Query Failed</errorno>
                                <description></description>
                                <description2>Object definition VENDOR9 not found</description2>
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
        $response = new OnlineResponse($xml);

        $results = $response->getResults();

        $results[0]->ensureStatusNotFailure();

        $this->addToAssertionCount(1);  //does not throw an exception
    }

    /**
     * Test no exception is thrown when status is success
     */
    public function testStatusSuccess(): void
    {

        $this->object->ensureStatusSuccess();

        $this->addToAssertionCount(1);  //does not throw an exception
    }

    public function testLegacyGetListClass(): void
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                <status>success</status>
                <function>get_list</function>
                <controlid>ccdeafa7-4f22-49ae-b6ae-b5e1a39423e7</controlid>
                <listtype start="0" end="1" total="2">class</listtype>
                <data>
                    <class>
                        <key>C1234</key>
                        <name>hello world</name>
                        <description/>
                        <parentid/>
                        <whenmodified>07/24/2017 15:19:46</whenmodified>
                        <status>active</status>
                    </class>
                    <class>
                        <key>C1235</key>
                        <name>hello world</name>
                        <description/>
                        <parentid/>
                        <whenmodified>07/24/2017 15:20:27</whenmodified>
                        <status>active</status>
                    </class>
                </data>
            </result>
      </operation>
</response>
EOF;

        $response = new OnlineResponse($xml);

        $result = $response->getResult();
        $this->assertEquals(0, $result->getStart());
        $this->assertEquals(1, $result->getEnd());
        $this->assertEquals(2, $result->getTotalCount());
        $this->assertCount(2, $result->getData());
    }

    public function testReadClass(): void
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <control>
        <status>success</status>
        <senderid>testsender</senderid>
        <controlid>ControlIdHere</controlid>
        <uniqueid>false</uniqueid>
        <dtdversion>3.0</dtdversion>
    </control>
    <operation>
        <authentication>
            <status>success</status>
            <userid>user</userid>
            <companyid>company</companyid>
            <locationid></locationid>
            <sessiontimestamp>2017-08-05T11:22:32-07:00</sessiontimestamp>
            <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
        </authentication>
        <result>
            <status>success</status>
            <function>read</function>
            <controlid>7cad3f85-d533-4ae4-80bc-e96e58b5a822</controlid>
            <data listtype="CUSTOMER" count="1">
                <CUSTOMER>
                    <RECORDNO>149</RECORDNO>
                    <CUSTOMERID>10074</CUSTOMERID>
                    <STATUS>active</STATUS>
                </CUSTOMER>
            </data>
        </result>
    </operation>
</response>
EOF;
        $response = new OnlineResponse($xml);

        $result = $response->getResult();
        $this->assertEquals(1, $result->getCount());
        $this->assertEquals('CUSTOMER', $result->getListType());
        $this->assertCount(1, $result->getData());
    }

    public function testLegacyReadByQueryClass(): void
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                <status>success</status>
                <function>readByQuery</function>
                <controlid>818b0a96-3faf-4931-97e6-1cf05818ea44</controlid>
                <data listtype="class" count="1" totalcount="2" numremaining="1" resultId="myResultId">
                    <class>
                        <RECORDNO>8</RECORDNO>
                        <CLASSID>C1234</CLASSID>
                        <NAME>hello world</NAME>
                        <DESCRIPTION></DESCRIPTION>
                        <STATUS>active</STATUS>
                        <PARENTKEY></PARENTKEY>
                        <PARENTID></PARENTID>
                        <PARENTNAME></PARENTNAME>
                        <WHENCREATED>07/24/2017 15:19:46</WHENCREATED>
                        <WHENMODIFIED>07/24/2017 15:19:46</WHENMODIFIED>
                        <CREATEDBY>9</CREATEDBY>
                        <MODIFIEDBY>9</MODIFIEDBY>
                        <MEGAENTITYKEY></MEGAENTITYKEY>
                        <MEGAENTITYID></MEGAENTITYID>
                        <MEGAENTITYNAME></MEGAENTITYNAME>
                    </class>
                </data>
            </result>
      </operation>
</response>
EOF;

        $response = new OnlineResponse($xml);

        $result = $response->getResult();
        $this->assertEquals(1, $result->getCount());
        $this->assertEquals(2, $result->getTotalCount());
        $this->assertEquals(1, $result->getNumRemaining());
        $this->assertEquals('myResultId', $result->getResultId());
        $this->assertCount(1, $result->getData());
    }

    public function testLegacyCreateClassKey(): void
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
                  <sessiontimeout>2015-10-26T10:08:34-07:00</sessiontimeout>
            </authentication>
            <result>
                <status>success</status>
                <function>create_class</function>
                <controlid>d4814563-1e97-4708-b9c5-9a49569d2a0d</controlid>
                <key>C1234</key>
            </result>
      </operation>
</response>
EOF;

        $response = new OnlineResponse($xml);

        $result = $response->getResult();
        $this->assertEquals('C1234', $result->getKey());
    }
}
