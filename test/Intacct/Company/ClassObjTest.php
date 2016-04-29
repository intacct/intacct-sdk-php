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

namespace Intacct\Tests\Company;

use Intacct\IntacctClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Intacct\IntacctClient;
use Intacct\Xml\Request\Operation\Content\Record;
use DOMDocument;
use Intacct\Tests\XMLTestCase;

class ClassObjTest extends XMLTestCase
{

    /**
     *
     * @var IntacctClientInterface
     */
    private $client;

    /**
     * @var DOMDocument
     */
    private $domDoc;

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

    public function getDomDocument()
    {
        return $this->domDoc;
    }

    private function setDomDocumet($domDoc)
    {
        $this->domDoc = $domDoc;
    }

    /**
     * @covers Intacct\Dimension\ClassObj::create
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     */
    public function testCreateSuccess()
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
            'standard_fields' => [
                'CLASSID' => 'UT01',
                'NAME' => 'Unit Test 01',
                'DESCRIPTION' => 'Some description',
                'STATUS' => 'active',
                'PARENTID' => 'MA'
            ],
            'custom_fields' => [
                'FOO' => 'BAR',
            ],

            'mock_handler' => $mock,
        ];

        $data = $this->client->getCompany()->getClassObj()->create($create);

        $request = $mock->getLastRequest();

        $requestXML = $request->getBody()->getContents();

        // Verify request XML through XPath
        $dom = new DomDocument();
        $dom->loadXML($requestXML);

        $this->setDomDocumet($dom);

        $this->assertXpathMatch('create',
            'name(/request/operation/content/function/*)',
            'function does not match');

        $this->assertXpathMatch('CLASS',
            'name(/request/operation/content/function/create/*)',
            'object does not match');

        $this->assertXpathMatch('UT01Unit Test 01Some descriptionactiveMABAR',
            'string(/request/operation/content/function/create/*)',
            'object does not match');

        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'create');
        $this->assertEquals($data->getControlId(), 'create');
    }

    /**
     * @covers Intacct\Company\ClassObj::create
     * @expectedException \Intacct\Xml\ParameterListException
     * @expectedExceptionMessage Missing standard_fields or custom_fields in parameters
     */
    public function testCreateWithoutParameters()
    {
        $create = [];

        $this->client->getCompany()->getClassObj()->create($create);
    }

    /**
     * @covers Intacct\Company\ClassObj::create
     * @expectedException \Intacct\Xml\ParameterListException
     * @expectedExceptionMessage Invalid standard_field given: PARENT
     */
    public function testCreateWithInvalidStandardFieldParameter()
    {
        $create = [
            'standard_fields' => [
                'CLASSID' => 'UT01',
                'NAME' => 'Unit Test 01',
                'DESCRIPTION' => 'Some description',
                'STATUS' => 'active',
                'PARENT' => 'MA'
            ],
            'custom_fields' => [
                'FOO' => 'BAR',
            ]
        ];

        $this->client->getCompany()->getClassObj()->create($create);
    }

    /**
     * @covers Intacct\Company\ClassObj::create
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     */
    public function testCreateWithCustomFieldParameters()
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
            'custom_fields' => [
                'FOO' => 'BAR',
            ],
            'mock_handler' => $mock
        ];

        $this->client->getCompany()->getClassObj()->create($create);

        $request = $mock->getLastRequest();

        $requestXML = $request->getBody()->getContents();

        // Verify request XML through XPath
        $dom = new DomDocument();
        $dom->loadXML($requestXML);

        $this->setDomDocumet($dom);

        $this->assertXpathMatch('create',
            'name(/request/operation/content/function/*)',
            'function does not match');

        $this->assertXpathMatch('CLASS',
            'name(/request/operation/content/function/create/*)',
            'object does not match');

        $this->assertXpathMatch('BAR',
            'string(/request/operation/content/function/create/*)',
            'object does not match');

    }


    /*
     * @covers Intacct\Company\ClassObj::create
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to create records
     */
//    public function testCreateFailure()
//    {
//        $xml = <<<EOF
//<?xml version="1.0" encoding="UTF-8"?
//<response>
//      <control>
//            <status>success</status>
//            <senderid>testsenderid</senderid>
//            <controlid>requestControlId</controlid>
//            <uniqueid>false</uniqueid>
//            <dtdversion>3.0</dtdversion>
//      </control>
//      <operation>
//            <authentication>
//                  <status>success</status>
//                  <userid>testuser</userid>
//                  <companyid>testcompany</companyid>
//                  <sessiontimestamp>2016-01-24T14:26:56-08:00</sessiontimestamp>
//            </authentication>
//            <result>
//                  <status>failure</status>
//                  <function>create</function>
//                  <controlid>create</controlid>
//                  <data listtype="objects" count="0"/>
//                  <errormessage>
//                        <error>
//                              <errorno>BL34000061</errorno>
//                              <description></description>
//                              <description2>Another Class with the given value(s) UT01  already exists</description2>
//                              <correction>Use a unique value instead.</correction>
//                        </error>
//                        <error>
//                              <errorno>BL01001973</errorno>
//                              <description></description>
//                              <description2>Could not create class record!</description2>
//                              <correction></correction>
//                        </error>
//                        <error>
//                              <errorno>BL01001973</errorno>
//                              <description></description>
//                              <description2>Could not create Class record!</description2>
//                              <correction></correction>
//                        </error>
//                  </errormessage>
//            </result>
//      </operation>
//</response>
//EOF;
//        $headers = [
//            'Content-Type' => 'text/xml; encoding="UTF-8"',
//        ];
//        $mockResponse = new Response(200, $headers, $xml);
//        $mock = new MockHandler([
//            $mockResponse,
//        ]);
//
//        $create = [
//            'records' => [
//                new Record([
//                    'object' => 'CLASS',
//                    'fields' => [
//                        'CLASSID' => 'UT01',
//                        'NAME' => 'Unit Test 01',
//                    ],
//                ]),
//                new Record([
//                    'object' => 'CLASS',
//                    'fields' => [
//                        'CLASSID' => 'UT02',
//                        'NAME' => 'Unit Test 02',
//                    ],
//                ]),
//            ],
//            'mock_handler' => $mock,
//        ];
//        $this->client->getCompany()->getClassObj()->create($create);
//    }
    /*
         * TODO To be updated
         * @covers Intacct\Company\ClassObj::delete
         * @covers Intacct\Xml\RequestHandler::executeContent
         * @covers Intacct\IntacctClient::getSessionConfig
         * @expectedException InvalidArgumentException
         * @expectedExceptionMessage Missing object declaration in parameters. Use "object" => "CLASS"
         */
//    public function testMissingObjectParameter()
//    {
//        $delete = [
//            'keys' => [
//                '5',
//                '6',
//            ],
//        ];
//
//        $this->client->getCompany()->getClassObj()->delete($delete);
//    }


    /*
     * TODO To be updated
     * @covers Intacct\Company\ClassObj::create
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Missing object declaration in parameters. Use "object" => "CLASS"
     */
//    public function testMissingObjectParameterInRecords()
//    {
//        $create = [
//            'records' => [
//                new Record([
//                    'object' => 'CLASS',
//                    'fields' => [
//                        'CLASSID' => 'UT01',
//                        'NAME' => 'Unit Test 01',
//                    ],
//                ]),
//                new Record([
//                    'object' => 'CLASS1',
//                    'fields' => [
//                        'CLASSID' => 'UT02',
//                        'NAME' => 'Unit Test 02',
//                    ],
//                ]),
//            ],
//        ];
//
//        $this->client->getCompany()->getClassObj()->create($create);
//    }

    /**
     * @covers Intacct\Company\ClassObj::update
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     */
    public function testUpdateSuccess()
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
        $data = $this->client->getCompany()->getClassObj()->update($update);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'update');
        $this->assertEquals($data->getControlId(), 'update');
    }

    /**
     * @covers Intacct\Company\ClassObj::update
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to update records
     */
    public function testUpdateFailure()
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
        $this->client->getCompany()->getClassObj()->update($update);
    }

    /**
     * @covers Intacct\Company\ClassObj::delete
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     */
    public function testDeleteSuccess()
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
        $data = $this->client->getCompany()->getClassObj()->delete($delete);
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'delete');
        $this->assertEquals($data->getControlId(), 'delete');
    }

    /**
     * @covers Intacct\Company\ClassObj::delete
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to delete records
     */
    public function testDeleteFailure()
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
        $this->client->getCompany()->getClassObj()->delete($delete);
    }

    /**
     * @covers Intacct\Company\ClassObj::inspect
     * @covers Intacct\Xml\RequestHandler::executeContent
     * @covers Intacct\IntacctClient::getSessionConfig
     */
    public function testInspectSuccess()
    {
        $fileName = __DIR__ . '/InspectClassResponse.xml';
        $xmlfile = fopen($fileName, "r") or die("Unable to open file " . $fileName . "!");
        $xml =  fread($xmlfile,filesize($fileName));
        fclose($xmlfile);

        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $mockResponse = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $mockResponse,
        ]);

        $inspect = [
            'object' => 'CLASS',
            'control_id' => 'inspect',
            'show_detail' => true,
            'mock_handler' => $mock,

        ];

        $data = $this->client->getCompany()->getClassObj()->inspect($inspect);

        $request = $mock->getLastRequest();

        $requestXML = $request->getBody()->getContents();

        $dom = new DomDocument();
        $dom->loadXML($requestXML);

        $this->setDomDocumet($dom);

        // Verify request elements
        $this->assertXpathMatch('testsenderid',
            'string(/request/control/senderid)',
            'senderid does not match');

        $this->assertXpathMatch('pass123!',
            'string(/request/control/password)',
            'password does not match');

        $this->assertXpathMatch('inspect',
            'string(/request/control/controlid)',
            'controlid does not match');

        $this->assertXpathMatch('false',
            'string(/request/control/uniqueid)',
            'uniqueid does not match');

        $this->assertXpathMatch('3.0',
            'string(/request/control/dtdversion)',
            'dtdversion does not match');

        $this->assertXpathMatch('inspect',
            'name(/request/operation/content/function/*)',
            'function does not match');

        $this->assertXpathMatch('CLASS',
            'string(/request/operation/content/function/inspect/object)',
            'object does not match');

        // Verify response
        $this->assertEquals($data->getStatus(), 'success');
        $this->assertEquals($data->getFunction(), 'inspect');
        $this->assertEquals($data->getControlId(), 'inspect');
    }

    /*
     * @covers Intacct\Company\ClassObj::inspect
     * @expectedException \Intacct\Xml\Response\Operation\ResultException
     * @expectedExceptionMessage An error occurred trying to inspect an object
     */
//    public function testInspectFailure()
//    {
//        $fileName = __DIR__ . '/InspectClassResponse.xml';
//        $xmlfile = fopen($fileName, "r") or die("Unable to open file " . $fileName . "!");
//        $xml =  <<<EOF
//<?xml version="1.0" encoding="UTF-8"?
//<response>
//      <control>
//            <status>success</status>
//            <senderid>testsenderid</senderid>
//            <controlid>requestControlId</controlid>
//            <uniqueid>false</uniqueid>
//            <dtdversion>3.0</dtdversion>
//      </control>
//      <operation>
//            <authentication>
//                  <status>success</status>
//                  <userid>testuser</userid>
//                  <companyid>testcompany</companyid>
//                  <sessiontimestamp>2016-01-24T14:26:56-08:00</sessiontimestamp>
//            </authentication>
//            <result>
//                <status>failure</status>
//                <function>inspect</function>
//                <controlid>inspect</controlid>
//                <errormessage>
//                    <error>
//                        <errorno>XXX</errorno>
//                        <description></description>
//                        <description2>Object type CLASS1 not found</description2>
//                        <correction></correction>
//                    </error>
//                </errormessage>
//            </result>
//      </operation>
//</response>
//EOF;
//        $headers = [
//            'Content-Type' => 'text/xml; encoding="UTF-8"',
//        ];
//        $mockResponse = new Response(200, $headers, $xml);
//        $mock = new MockHandler([
//            $mockResponse,
//        ]);
//
//        $inspect = [
//            'object' => 'CLASS1',
//            'control_id' => 'inspect',
//            'show_detail' => true,
//            'mock_handler' => $mock,
//        ];
//
//        $this->client->getCompany()->getClassObj()->inspect($inspect);
//        $request = $mock->getLastRequest()->getBody()->getContents();
//        $this->assertTrue(strpos($inspect['object'],$request));
//    }
}