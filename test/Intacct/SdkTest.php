<?php

namespace Intacct;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Intacct\Xml\Request\Operation\Content\Implicit\Record;

class SdkTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var Sdk
     */
    private $ia;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        //the SDK constructor will always get a session id, so mock it
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
        
        $this->ia = new Sdk([
            'sender_id' => 'intacct_dev',
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
     * @covers Intacct\Sdk::__construct
     * @covers Intacct\Sdk::getSessionCreds
     * @covers Intacct\Sdk::getLastExecution
     */
    public function testConstructWithSessionId()
    {
        $ia = $this->ia; //grab the setUp object
        
        $creds = $ia->getSessionCreds();
        $this->assertEquals($creds->getEndpoint(), 'https://p1.intacct.com/ia/xml/xmlgw.phtml');
        $this->assertEquals($creds->getSessionId(), 'testSeSsionID..');
        $this->assertEquals(count($ia->getLastExecution()), 1);
    }
    
    /**
     * @covers Intacct\Sdk::__construct
     * @covers Intacct\Sdk::getSessionCreds
     * @covers Intacct\Sdk::getLastExecution
     */
    public function testConstructWithLogin()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
        
        $ia = new Sdk([
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'originalSeSsIonID..',
            'mock_handler' => $mock,
        ]);
        
        $creds = $ia->getSessionCreds();
        $this->assertEquals($creds->getEndpoint(), 'https://p1.intacct.com/ia/xml/xmlgw.phtml');
        $this->assertEquals($creds->getSessionId(), 'helloworld..');
        $this->assertEquals(count($ia->getLastExecution()), 1);
    }

    /**
     * @covers Intacct\Sdk::executeContent
     * @todo   Implement testExecuteContent().
     */
    public function testExecuteContent()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\Sdk::executeContentAsync
     * @todo   Implement testExecuteContentAsync().
     */
    public function testExecuteContentAsync()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\Sdk::readByQuery
     * @todo   Implement testReadByQuery().
     */
    public function testReadByQuery()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\Sdk::readView
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
     * @covers Intacct\Sdk::readReport
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
     * @covers Intacct\Sdk::getQueryRecords
     * @todo   Implement testGetQueryRecords().
     */
    public function testGetQueryRecords()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\Sdk::getViewRecords
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
     * @covers Intacct\Sdk::getReportRecords
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
     * @covers Intacct\Sdk::readMore
     * @todo   Implement testReadMore().
     */
    public function testReadMore()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\Sdk::read
     * @covers Intacct\Sdk::executeContent
     */
    public function testReadSuccess()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
        $data = $this->ia->read($read);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'read');
        $this->assertEquals($data->getControlId(), 'read');
    }

    /**
     * @covers Intacct\Sdk::read
     * @covers Intacct\Sdk::executeContent
     * @expectedException Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to read records
     */
    public function testReadFailure()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
        $data = $this->ia->read($read);
    }

    /**
     * @covers Intacct\Sdk::readByName
     * @covers Intacct\Sdk::executeContent
     */
    public function testReadByNameSuccess()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
        $data = $this->ia->readByName($readByName);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'readByName');
        $this->assertEquals($data->getControlId(), 'readByName');
    }

    /**
     * @covers Intacct\Sdk::readByName
     * @covers Intacct\Sdk::executeContent
     * @expectedException Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to read records by name
     */
    public function testReadByNameFailure()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
        $data = $this->ia->readByName($readByName);
    }

    /**
     * @covers Intacct\Sdk::readRelated
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
     * @covers Intacct\Sdk::getUserPermissions
     * @todo   Implement testGetUserPermissions().
     */
    public function testGetUserPermissions()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Intacct\Sdk::create
     * @covers Intacct\Sdk::executeContent
     * @covers Intacct\Sdk::getSessionConfig
     */
    public function testCreateSuccess()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
                  <function>create</function>
                  <controlid>create</controlid>
                  <data listtype="objects" count="2">
                        <class>
                              <RECORDNO>5</RECORDNO>
                              <CLASSID>UT01</CLASSID>
                        </class>
                        <class>
                              <RECORDNO>6</RECORDNO>
                              <CLASSID>UT02</CLASSID>
                        </class>
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
        
        $create = [
            'records' => [
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT01',
                        'NAME' => 'Unit Test 01',
                    ],
                ]),
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT02',
                        'NAME' => 'Unit Test 02',
                    ],
                ]),
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->ia->create($create);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'create');
        $this->assertEquals($data->getControlId(), 'create');
    }

    /**
     * @covers Intacct\Sdk::create
     * @covers Intacct\Sdk::executeContent
     * @covers Intacct\Sdk::getSessionConfig
     * @expectedException Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to create records
     */
    public function testCreateFailure()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
                  <function>create</function>
                  <controlid>create</controlid>
                  <data listtype="objects" count="0"/>
                  <errormessage>
                        <error>
                              <errorno>BL34000061</errorno>
                              <description></description>
                              <description2>Another Class with the given value(s) UT01  already exists</description2>
                              <correction>Use a unique value instead.</correction>
                        </error>
                        <error>
                              <errorno>BL01001973</errorno>
                              <description></description>
                              <description2>Could not create class record!</description2>
                              <correction></correction>
                        </error>
                        <error>
                              <errorno>BL01001973</errorno>
                              <description></description>
                              <description2>Could not create Class record!</description2>
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
        
        $create = [
            'records' => [
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT01',
                        'NAME' => 'Unit Test 01',
                    ],
                ]),
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT02',
                        'NAME' => 'Unit Test 02',
                    ],
                ]),
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->ia->create($create);
    }

    /**
     * @covers Intacct\Sdk::update
     * @covers Intacct\Sdk::executeContent
     * @covers Intacct\Sdk::getSessionConfig
     */
    public function testUpdateSuccess()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
                  <function>update</function>
                  <controlid>update</controlid>
                  <data listtype="objects" count="2">
                        <class>
                              <RECORDNO>5</RECORDNO>
                              <CLASSID>UT01</CLASSID>
                        </class>
                        <class>
                              <RECORDNO>6</RECORDNO>
                              <CLASSID>UT02</CLASSID>
                        </class>
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
        
        $update = [
            'records' => [
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT01',
                        'NAME' => 'Unit Test 01',
                    ],
                ]),
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT02',
                        'NAME' => 'Unit Test 02',
                    ],
                ]),
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->ia->update($update);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'update');
        $this->assertEquals($data->getControlId(), 'update');
    }

    /**
     * @covers Intacct\Sdk::update
     * @covers Intacct\Sdk::executeContent
     * @covers Intacct\Sdk::getSessionConfig
     * @expectedException Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to update records
     */
    public function testUpdateFailure()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
                  <function>update</function>
                  <controlid>create</controlid>
                  <data listtype="objects" count="1">
                        <class>
                              <RECORDNO>5</RECORDNO>
                              <CLASSID>UT01</CLASSID>
                        </class>
                  </data>
                  <errormessage>
                        <error>
                              <errorno>Cannot update non-existing CLASS with CLASSID=UT99.</errorno>
                              <description></description>
                              <description2></description2>
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
        
        $update = [
            'records' => [
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT01',
                        'NAME' => 'Unit Test 01',
                    ],
                ]),
                new Record([
                    'object' => 'CLASS',
                    'fields' => [
                        'CLASSID' => 'UT99',
                        'NAME' => 'Unit Test 99',
                    ],
                ]),
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->ia->update($update);
    }

    /**
     * @covers Intacct\Sdk::delete
     * @covers Intacct\Sdk::executeContent
     * @covers Intacct\Sdk::getSessionConfig
     */
    public function testDeleteSuccess()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
                  <function>delete</function>
                  <controlid>delete</controlid>
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
        
        $delete = [
            'object' => 'CLASS',
            'keys' => [
                '5',
                '6',
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->ia->delete($delete);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'delete');
        $this->assertEquals($data->getControlId(), 'delete');
    }
    
    /**
     * @covers Intacct\Sdk::delete
     * @covers Intacct\Sdk::executeContent
     * @covers Intacct\Sdk::getSessionConfig
     * @expectedException Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to delete records
     */
    public function testDeleteFailure()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
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
                  <function>delete</function>
                  <controlid>delete</controlid>
                  <errormessage>
                        <error>
                              <errorno>BL01001973</errorno>
                              <description></description>
                              <description2>Cannot find class with key &#039;UT01&#039; to delete.</description2>
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
        
        $delete = [
            'object' => 'CLASS',
            'keys' => [
                'UT01',
                'UT02',
            ],
            'mock_handler' => $mock,
        ];
        $data = $this->ia->delete($delete);
    }

}
