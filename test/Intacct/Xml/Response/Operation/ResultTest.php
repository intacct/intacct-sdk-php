<?php
/**
 * Copyright 2017 Sage Intacct, Inc.
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

namespace Intacct\Xml\Response\Operation;

use Intacct\Xml\SynchronousResponse;
use Exception;

/**
 * @coversDefaultClass \Intacct\Xml\Response\Operation\Result
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Result
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
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
        $response = new SynchronousResponse($xml);
        $operation = $response->getOperation();
        $results = $operation->getResults();
        $this->object = $results[0];
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testConstruct()
    {
        $this->assertThat($this->object, $this->isInstanceOf('Intacct\Xml\Response\Operation\Result'));
    }

    public function testGetStatus()
    {
        $this->assertEquals('success', $this->object->getStatus());
    }

    public function testGetFunction()
    {
        $this->assertEquals('readByQuery', $this->object->getFunction());
    }

    public function testGetControlId()
    {
        $this->assertEquals('testControlId', $this->object->getControlId());
    }

    public function testGetData()
    {
        $this->assertThat($this->object->getData(), $this->isInstanceOf('SimpleXMLIterator'));
    }

    public function testGetErrors()
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
                  <sessiontimestamp>2015-10-25T11:07:22-07:00</sessiontimestamp>
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
        $response = new SynchronousResponse($xml);
        $operation = $response->getOperation();
        $results = $operation->getResults();
        $result = $results[0];

        $this->assertEquals('failure', $result->getStatus());
        $this->assertInternalType('array', $result->getErrors());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing status element
     */
    public function testMissingStatusElement()
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
        new SynchronousResponse($xml);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing function element
     */
    public function testMissingFunctionElement()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
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
        new SynchronousResponse($xml);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing controlid element
     */
    public function testMissingControlIdElement()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
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
        new SynchronousResponse($xml);
    }

    /**
     * @expectedException \Intacct\Exception\ResultException
     * @expectedExceptionMessage Result status: failure
     */
    public function testStatusFailure()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
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
        $response = new SynchronousResponse($xml);

        $results = $response->getOperation()->getResults();

        $results[0]->ensureStatusNotFailure();
    }

    /**
     * @expectedException \Intacct\Exception\ResultException
     * @expectedExceptionMessage Result status: aborted
     */
    public function testStatusAbort()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
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
        $response = new SynchronousResponse($xml);

        $results = $response->getOperation()->getResults();

        $results[0]->ensureStatusSuccess();
    }

    /**
     * Test no exception is thrown even though the status is aborted
     */
    public function testStatusNotFailureOnAborted()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
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
        $response = new SynchronousResponse($xml);

        $results = $response->getOperation()->getResults();

        $results[0]->ensureStatusNotFailure();

        $this->addToAssertionCount(1);  //does not throw an exception
    }

    /**
     * Test no exception is thrown when status is success
     */
    public function testStatusSuccess()
    {

        $this->object->ensureStatusSuccess();

        $this->addToAssertionCount(1);  //does not throw an exception
    }

    public function testLegacyKey()
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
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
            </authentication>
            <result>
                <status>success</status>
                <function>create_class</function>
                <controlid>d4814563-1e97-4708-b9c5-9a49569d2a0d</controlid>
                <key>C1235</key>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
        $operation = $response->getOperation();
        $results = $operation->getResults();
        $result = $results[0];

        $this->assertEquals('C1235', $result->getKey());
    }
}