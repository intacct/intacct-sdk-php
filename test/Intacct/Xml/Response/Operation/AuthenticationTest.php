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

namespace Intacct\Xml\Response\Operation;

use Intacct\Xml\SynchronousResponse;
use Exception;

class AuthenticationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Authentication
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
        $operation = $response->getOperation();
        
        $this->object = $operation->getAuthentication();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::getStatus
     */
    public function testGetStatus()
    {
        $this->assertEquals('success', $this->object->getStatus());
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::getUserId
     */
    public function testGetUserId()
    {
        $this->assertEquals('fakeuser', $this->object->getUserId());
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::getCompanyId
     */
    public function testGetCompanyId()
    {
        $this->assertEquals('fakecompany', $this->object->getCompanyId());
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::getSlideInUser
     */
    public function testGetSlideInUserDirectLogin()
    {
        $this->assertEquals(false, $this->object->getSlideInUser());
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::__construct
     * @covers Intacct\Xml\Response\Operation\Authentication::setSlideInUser
     */
    public function testGetSlideInUserExternalLogin()
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
                  <userid>ExtUser|fakeconsole|fakeuser</userid>
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
        $operation = $response->getOperation();
        $authentication = $operation->getAuthentication();
        
        $this->assertEquals('ExtUser|fakeconsole|fakeuser', $authentication->getUserId());
        $this->assertEquals(true, $authentication->getSlideInUser());
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::__construct
     * @covers Intacct\Xml\Response\Operation\Authentication::setSlideInUser
     */
    public function testGetSlideInCPAUserLogin()
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
                  <userid>CPAUser</userid>
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
        $operation = $response->getOperation();
        $authentication = $operation->getAuthentication();
        
        $this->assertEquals('CPAUser', $authentication->getUserId());
        $this->assertEquals(true, $authentication->getSlideInUser());
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Authentication block is missing status element
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
                  <!--<status>success</status>-->
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
            </authentication>
            <result/>
      </operation>
</response>
EOF;
        new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Authentication block is missing userid element
     */
    public function testMissingUserIdElement()
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
                  <!--<userid>fakeuser</userid>-->
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
            </authentication>
            <result/>
      </operation>
</response>
EOF;
        new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Authentication::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Authentication block is missing companyid element
     */
    public function testMissingCompanyIdElement()
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
                  <!--<companyid>fakecompany</companyid>-->
                  <sessiontimestamp>2015-10-24T18:56:52-07:00</sessiontimestamp>
            </authentication>
            <result/>
      </operation>
</response>
EOF;
        new SynchronousResponse($xml);
    }
}
