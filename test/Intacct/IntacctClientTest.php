<?php

namespace Intacct;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Intacct\Xml\Request\Operation\Content;

class IntacctClientTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var IntacctClient
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
     * @covers Intacct\IntacctClient::__construct
     * @covers Intacct\IntacctClient::getSessionCreds
     * @covers Intacct\IntacctClient::getLastExecution
     */
    public function testConstructWithSessionId()
    {
        $client = $this->client; //grab the setUp object
        
        $creds = $client->getSessionConfig();
        $this->assertEquals($creds['endpoint_url'], 'https://p1.intacct.com/ia/xml/xmlgw.phtml');
        $this->assertEquals($creds['session_id'], 'testSeSsionID..');
        $this->assertEquals(count($client->getLastExecution()), 1);
    }
    
    /**
     * @covers Intacct\IntacctClient::__construct
     * @covers Intacct\IntacctClient::getSessionCreds
     * @covers Intacct\IntacctClient::getLastExecution
     */
    public function testConstructWithLogin()
    {
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
                              <sessionid>helloworld..</sessionid>
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
            'session_id' => 'originalSeSsIonID..',
            'mock_handler' => $mock,
        ]);
        
        $creds = $client->getSessionConfig();
        $this->assertEquals($creds['endpoint_url'], 'https://p1.intacct.com/ia/xml/xmlgw.phtml');
        $this->assertEquals($creds['session_id'], 'helloworld..');
        $this->assertEquals(count($client->getLastExecution()), 1);
    }

    /**
     * @covers Intacct\IntacctClient::readByQuery
     */
    public function testReadByQuerySuccess()
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
                  <function>readByQuery</function>
                  <controlid>readByQuery</controlid>
                  <data listtype="glaccount" count="2" totalcount="2" numremaining="0" resultId="">
                        <glaccount>
                              <RECORDNO>47</RECORDNO>
                              <ACCOUNTNO>1010</ACCOUNTNO>
                              <TITLE>Cash in Bank, Checking, BA1145</TITLE>
                        </glaccount>
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
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);
        
        $readByQuery = [
            'object' => 'GLACCOUNT',
            'fields' => [
                'RECORDNO',
                'ACCOUNTNO',
                'TITLE',
            ],
            'query' => "ACCOUNTNO = '1010' OR ACCOUNTNO = '1020'",
            'mock_handler' => $mock,
        ];
        $data = $this->client->readByQuery($readByQuery);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'readByQuery');
        $this->assertEquals($data->getControlId(), 'readByQuery');
    }

    /**
     * @covers Intacct\IntacctClient::readByQuery
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to read query records
     */
    public function testReadByQueryFailure()
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
                  <function>readByQuery</function>
                  <controlid>readByQuery</controlid>
                  <errormessage>
                        <error>
                              <errorno>DL02000001</errorno>
                              <description>Error</description>
                              <description2>There was an error processing the request.</description2>
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
        
        $readByQuery = [
            'object' => 'GLACCOUNT',
            'fields' => [
                'RECORDNO',
                'ACCOUNTNO',
                'TITLE',
            ],
            'query' => "this is not a query",
            'mock_handler' => $mock,
        ];
        $this->client->readByQuery($readByQuery);
    }

    /**
     * @covers Intacct\IntacctClient::readView
     * @todo   Implement testReadView().
     */
    public function testReadView()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\IntacctClient::readReport
     * @todo   Implement testReadReport().
     */
    public function testReadReport()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\IntacctClient::getQueryRecords
     * @covers Intacct\IntacctClient::readByQuery
     * @covers Intacct\IntacctClient::readMore
     */
    public function testGetQueryRecordsSuccess()
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
        $data = $this->client->getQueryRecords($readByQuery);
        $this->assertCount(2, $data);
    }

    /**
     * @covers Intacct\IntacctClient::getViewRecords
     * @todo   Implement testGetViewRecords().
     */
    public function testGetViewRecords()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\IntacctClient::getReportRecords
     * @todo   Implement testGetReportRecords().
     */
    public function testGetReportRecords()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\IntacctClient::readMore
     */
    public function testReadMoreSuccess()
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
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);

        $config = [
            'result_id' => '7765623330Vqb8pMCoA4IAAEnuglgAAAAL5',
            'mock_handler' => $mock,
        ];
        $data = $this->client->readMore($config);
        $this->assertEquals('success', $data->getStatus());
        $this->assertEquals('readMore', $data->getFunction());
        $this->assertEquals('readMore', $data->getControlId());
    }

    /**
     * @covers Intacct\IntacctClient::read
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to read more records
     */
    public function testReadMoreFailure()
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
                  <function>readMore</function>
                  <controlid>readMore</controlid>
                  <errormessage>
                        <error>
                              <errorno>readMore failed</errorno>
                              <description></description>
                              <description2>Attempt to readMore with an invalid or expired resultId: bad</description2>
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

        $readMore = [
            'result_id' => 'bad',
            'mock_handler' => $mock,
        ];
        $this->client->readMore($readMore);
    }

    /**
     * @covers Intacct\IntacctClient::read
     * @covers Intacct\Xml\RequestHandler::executeContent
     */
    public function testReadSuccess()
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
        $data = $this->client->read($read);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'read');
        $this->assertEquals($data->getControlId(), 'read');
    }

    /**
     * @covers Intacct\IntacctClient::read
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
        $this->client->read($read);
    }

    /**
     * @covers Intacct\IntacctClient::readByName
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
        $data = $this->client->readByName($readByName);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'readByName');
        $this->assertEquals($data->getControlId(), 'readByName');
    }

    /**
     * @covers Intacct\IntacctClient::readByName
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
        $this->client->readByName($readByName);
    }

    /**
     * @covers Intacct\IntacctClient::readRelated
     * @todo   Implement testReadRelated().
     */
    public function testReadRelated()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\IntacctClient::getUserPermissions
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
        $permissions = $this->client->getUserPermissions($config);
        $this->assertEquals($permissions->getStatus(), 'success');
        $this->assertEquals($permissions->getFunction(), 'getUserPermissions');
        $this->assertEquals($permissions->getControlId(), 'getUserPermissions');
    }

    /**
     * @covers Intacct\IntacctClient::getUserPermissions
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
        $this->client->getUserPermissions($config);
    }

    /**
     * @covers Intacct\IntacctClient::installApp
     * @todo   Implement testInstallApp().
     */
    public function testInstallApp()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
