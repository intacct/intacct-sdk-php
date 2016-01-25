<?php

namespace Intacct\Xml;

use Intacct\Xml\Request\Operation\Content;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }
    
    /**
     * @covers Intacct\Xml\Request::__construct
     * @covers Intacct\Xml\Request::getXml
     * @covers Intacct\Xml\Request::getVerifySSL
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="iso-8859-1"?>
<request>
    <control>
        <senderid>intacct_dev</senderid>
        <password>pass123!</password>
        <controlid>requestControlId</controlid>
        <uniqueid>false</uniqueid>
        <dtdversion>3.0</dtdversion>
        <policyid/>
        <includewhitespace>false</includewhitespace>
    </control>
    <operation transaction="false">
        <authentication>
            <sessionid>testsession..</sessionid>
        </authentication>
        <content></content>
    </operation>
</request>
EOF;
        
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
        ];
        
        $content = new Content();
        
        $request = new Request($config, $content);
        
        $xml = $request->getXml();
        
        $this->assertEquals($request->getVerifySSL(), true);
        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @covers Intacct\Xml\Request::getVerifySSL
     */
    public function testGetVerifySSL()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'verify_ssl' => false,
        ];

        $content = new Content();

        $request = new Request($config, $content);
        
        $this->assertEquals($request->getVerifySSL(), false);
    }
    
    /**
     * @covers Intacct\Xml\Request::setMaxRetries
     * @covers Intacct\Xml\Request::getMaxRetries
     */
    public function testSetMaxRetries()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => 10,
        ];

        $content = new Content();

        $request = new Request($config, $content);
        
        $this->assertEquals($request->getMaxRetries(), 10);
    }
    
    /**
     * @covers Intacct\Xml\Request::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Requested encoding is not supported
     */
    public function testInvalidEncoding()
    {
        $config = [
            'encoding' => 'invalid',
        ];

        $content = new Content();

        $request = new Request($config, $content);
    }
    
    /**
     * @covers Intacct\Xml\Request::setMaxRetries
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage max retries not valid int type
     */
    public function testSetMaxRetriesInvalidType()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => '10',
        ];

        $content = new Content();

        $request = new Request($config, $content);
    }
    
    /**
     * @covers Intacct\Xml\Request::setMaxRetries
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage max retries must be zero or greater
     */
    public function testSetMaxRetriesInvalidInt()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => -1,
        ];

        $content = new Content();

        $request = new Request($config, $content);
    }
    
    /**
     * @covers Intacct\Xml\Request::setNoRetryServerErrorCodes
     * @covers Intacct\Xml\Request::getNoRetryServerErrorCodes
     */
    public function testSetNoRetryServerErrorCodes()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                502,
                524,
            ],
        ];

        $content = new Content();

        $request = new Request($config, $content);
        $expected = [
            502,
            524,
        ];
        $this->assertEquals($request->getNoRetryServerErrorCodes(), $expected);
    }
    
    /**
     * @covers Intacct\Xml\Request::setNoRetryServerErrorCodes
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage no retry server error code is not valid int type
     */
    public function testSetNoRetryServerErrorCodesInvalidInt()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                '500',
                '524',
            ],
        ];

        $content = new Content();

        $request = new Request($config, $content);
    }
    
    /**
     * @covers Intacct\Xml\Request::setNoRetryServerErrorCodes
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage no retry server error code must be between 500-599
     */
    public function testSetNoRetryServerErrorCodesInvalidRange()
    {
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                200,
            ],
        ];

        $content = new Content();

        $request = new Request($config, $content);
    }
    
    /**
     * @covers Intacct\Xml\Request::__construct
     * @covers Intacct\Xml\Request::execute
     * @covers Intacct\Xml\Request::getHistory
     * @covers Intacct\Xml\Request::getUserAgent
     */
    public function testMockExecute()
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
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $content = new Content();
        
        $request = new Request($config, $content);
        $response = $request->execute();
        
        $this->assertXmlStringEqualsXmlString($xml, $response->getBody());
        $history = $request->getHistory();
        $this->assertEquals(count($history), 1);
    }
    
    /**
     * @covers Intacct\Xml\Request::__construct
     * @covers Intacct\Xml\Request::execute
     */
    public function testMockRetry()
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
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        
        $mock = new MockHandler([
            new Response(502), 
            new Response(200, $headers, $xml),
        ]);
        
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $content = new Content();
        
        $request = new Request($config, $content);
        $response = $request->execute();
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * @covers Intacct\Xml\Request::__construct
     * @covers Intacct\Xml\Request::execute
     * @expectedException GuzzleHttp\Exception\ServerException
     */
    public function testMockDefaultRetryFailure()
    {
        $mock = new MockHandler([
            new Response(500), 
            new Response(501), 
            new Response(502), 
            new Response(504),
            new Response(505),
            new Response(506),
        ]);
        
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $content = new Content();
        
        $request = new Request($config, $content);
        $response = $request->execute();
    }
    
    /**
     * @covers Intacct\Xml\Request::__construct
     * @covers Intacct\Xml\Request::execute
     * @expectedException GuzzleHttp\Exception\ServerException
     */
    public function testMockDefaultNo524Retry()
    {
        $mock = new MockHandler([
            new Response(524),
        ]);
        
        $config = [
            'sender_id' => 'intacct_dev',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $content = new Content();
        
        $request = new Request($config, $content);
        $response = $request->execute();
    }

}
