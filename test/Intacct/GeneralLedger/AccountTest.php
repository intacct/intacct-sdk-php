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

namespace Intacct\GeneralLedger;

use Intacct\IntacctClientInterface;
use Intacct\IntacctClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var IntacctClientInterface
     */
    private $client;

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

        $this->client = new IntacctClient([
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
            'mock_handler' => $mock,
        ]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers Intacct\GeneralLedger\Account::getAllByQuery
     * @covers Intacct\GeneralLedger\Accoutn::readFirstPageByQuery
     * @covers Intacct\GeneralLedger\Account::readMore
     */
    public function testGetAllByQuerySuccess()
    {
        $xml1 = <<<EOF
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
                  <function>readByQuery</function>
                  <controlid>readByQuery</controlid>
                  <data listtype="glaccount" count="1" totalcount="2" numremaining="1" resultId="7765623330Vqb8pMCoA4IAAEnuglgAAAAL5">
                        <glaccount>
                              <RECORDNO>47</RECORDNO>
                              <ACCOUNTNO>1010</ACCOUNTNO>
                              <TITLE>Cash in Bank, Checking, BA1145</TITLE>
                        </glaccount>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $xml2 = <<<EOF
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
                  <function>readMore</function>
                  <controlid>readMore</controlid>
                  <data listtype="glaccount" count="1" totalcount="2" numremaining="0" resultId="7765623330Vqb8pMCoA4IAAEnuglgAAAAL5">
                        <glaccount>
                              <RECORDNO>55</RECORDNO>
                              <ACCOUNTNO>1020</ACCOUNTNO>
                              <TITLE>Cash in Bank, Checking, BA1343</TITLE>
                        </glaccount>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $mockResponse1 = new Response(200, $headers, $xml1);
        $mockResponse2 = new Response(200, $headers, $xml2);
        $mock = new MockHandler([
            $mockResponse1,
            $mockResponse2,
        ]);

        $readByQuery = [
            'object' => 'GLACCOUNT',
            'fields' => [
                'RECORDNO',
                'ACCOUNTNO',
                'TITLE',
            ],
            'query' => "ACCOUNTNO = '1010' OR ACCOUNTNO = '1020'",
            'page_size' => 1,
            'mock_handler' => $mock,
        ];
        $data = $this->client->getGeneralLedger()->getAccount()->readAllByQuery($readByQuery);
        $this->assertCount(2, $data);
    }


    /**
     * @covers Intacct\GeneralLedger\Account::readById
     * @covers Intacct\Xml\RequestHandler::executeContent
     */
    public function testReadByIdSuccess()
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
                  <function>read</function>
                  <controlid>read</controlid>
                  <data listtype="GLACCOUNT" count="2">
                        <GLACCOUNT>
                              <RECORDNO>9</RECORDNO>
                              <ACCOUNTNO>1010</ACCOUNTNO>
                              <TITLE>SVB Operating</TITLE>
                        </GLACCOUNT>
                        <GLACCOUNT>
                              <RECORDNO>10</RECORDNO>
                              <ACCOUNTNO>1020</ACCOUNTNO>
                              <TITLE>SVB Money Market</TITLE>
                        </GLACCOUNT>
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

        $read = [
            'object' => 'GLACCOUNT',
            'fields' => [
                'RECORDNO',
                'ACCOUNTNO',
                'TITLE',
            ],
            'keys' => [
                '9',
                '10',
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->client->getGeneralLedger()->getAccount()->readById($read);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'read');
        $this->assertEquals($data->getControlId(), 'read');
    }

    /**
     * @covers Intacct\GeneralLedger\Account::readById
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to read records
     */
    public function testReadFailure()
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
                  <function>read</function>
                  <controlid>read</controlid>
                  <errormessage>
                        <error>
                              <errorno>XXX</errorno>
                              <description></description>
                              <description2>Object definition GLACCOUNT2 not found</description2>
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

        $read = [
            'object' => 'GLACCOUNT2',
            'mock_handler' => $mock,
        ];
        $this->client->getGeneralLedger()->getAccount()->readById($read);
    }

    /**
     * @covers Intacct\GeneralLedger\Account::readByName
     * @covers Intacct\Xml\RequestHandler::executeContent
     */
    public function testReadByNameSuccess()
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
                  <function>readByName</function>
                  <controlid>readByName</controlid>
                  <data listtype="GLACCOUNT" count="2">
                        <GLACCOUNT>
                              <RECORDNO>9</RECORDNO>
                              <ACCOUNTNO>1010</ACCOUNTNO>
                              <TITLE>SVB Operating</TITLE>
                        </GLACCOUNT>
                        <GLACCOUNT>
                              <RECORDNO>10</RECORDNO>
                              <ACCOUNTNO>1020</ACCOUNTNO>
                              <TITLE>SVB Money Market</TITLE>
                        </GLACCOUNT>
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

        $readByName = [
            'object' => 'GLACCOUNT',
            'fields' => [
                'RECORDNO',
                'ACCOUNTNO',
                'TITLE',
            ],
            'names' => [
                '1010',
                '1020',
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->client->getGeneralLedger()->getAccount()->readByName($readByName);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'readByName');
        $this->assertEquals($data->getControlId(), 'readByName');
    }

    /**
     * @covers Intacct\GeneralLedger\Account::readByName
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to read records by name
     */
    public function testReadByNameFailure()
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
                  <function>readByName</function>
                  <controlid>testControlId</controlid>
                  <errormessage>
                        <error>
                              <errorno>XXX</errorno>
                              <description></description>
                              <description2>Object definition GLACCOUNT2 not found</description2>
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

        $readByName = [
            'object' => 'GLACCOUNT2',
            'mock_handler' => $mock,
        ];
        $this->client->getGeneralLedger()->getAccount()->readByName($readByName);
    }
}