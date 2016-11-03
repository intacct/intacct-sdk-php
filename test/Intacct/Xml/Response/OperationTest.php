<?php
/**
 * Copyright 2016 Intacct Corporation.
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

namespace Intacct\Xml\Response;

use Intacct\Xml\SynchronousResponse;
use Exception;

class OperationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Operation
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
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getAPISession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>faKEsesSiOnId..</sessionid>
                              <endpoint>https://api.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
        
        $this->object = $response->getOperation();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Intacct\Xml\Response\Operation::__construct
     * @covers Intacct\Xml\Response\Operation::setAuthentication
     * @covers Intacct\Xml\Response\Operation::getAuthentication
     */
    public function testGetAuthentication()
    {
        $authentication = $this->object->getAuthentication();
        $this->assertThat($authentication, $this->isInstanceOf('Intacct\Xml\Response\Operation\Authentication'));
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation::__construct
     * @expectedException \Intacct\Exception\OperationException
     * @expectedExceptionMessage Response authentication status failure
     */
    public function testAuthenticationFailure()
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
                  <status>failure</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
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
        new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Authentication block is missing from operation element
     */
    public function testMissingAuthenticationBlock()
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
      <operation/>
</response>
EOF;
        new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing from operation element
     */
    public function testMissingResultBlock()
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
                  <sessiontimestamp>2015-10-22T20:58:27-07:00</sessiontimestamp>
            </authentication>
      </operation>
</response>
EOF;
        new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation::__construct
     * @covers Intacct\Xml\Response\Operation::setResult
     * @covers Intacct\Xml\Response\Operation::getResults
     */
    public function testGetResults()
    {
        $results = $this->object->getResults();
        $this->assertInternalType('array', $results);
    }
}
