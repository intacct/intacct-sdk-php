<?php

namespace Intacct\Xml;

use Intacct\Xml\Request\Operation\ContentBlock;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use InvalidArgumentException;

class RequestHandlerTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Xml\RequestHandler::getVerifySSL
     */
    public function testGetVerifySSL()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'verify_ssl' => false,
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config, $requestBlock);
        
        $this->assertEquals($requestHandler->getVerifySSL(), false);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::setMaxRetries
     * @covers Intacct\Xml\RequestHandler::getMaxRetries
     */
    public function testSetMaxRetries()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => 10,
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config, $requestBlock);
        
        $this->assertEquals($requestHandler->getMaxRetries(), 10);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Requested encoding is not supported
     */
    public function testInvalidEncoding()
    {
        $config = [
            'encoding' => 'invalid',
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);

    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::setMaxRetries
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage max retries not valid int type
     */
    public function testSetMaxRetriesInvalidType()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => '10',
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::setMaxRetries
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage max retries must be zero or greater
     */
    public function testSetMaxRetriesInvalidInt()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'max_retries' => -1,
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::setNoRetryServerErrorCodes
     * @covers Intacct\Xml\RequestHandler::getNoRetryServerErrorCodes
     */
    public function testSetNoRetryServerErrorCodes()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                502,
                524,
            ],
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config, $requestBlock);
        $expected = [
            502,
            524,
        ];
        $this->assertEquals($requestHandler->getNoRetryServerErrorCodes(), $expected);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::setNoRetryServerErrorCodes
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage no retry server error code is not valid int type
     */
    public function testSetNoRetryServerErrorCodesInvalidInt()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                '500',
                '524',
            ],
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::setNoRetryServerErrorCodes
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage no retry server error code must be between 500-599
     */
    public function testSetNoRetryServerErrorCodesInvalidRange()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'no_retry_server_error_codes' => [
                200,
            ],
        ];

        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        new RequestHandler($config, $requestBlock);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::__construct
     * @covers Intacct\Xml\RequestHandler::execute
     * @covers Intacct\Xml\RequestHandler::getHistory
     * @covers Intacct\Xml\RequestHandler::getUserAgent
     */
    public function testMockExecute()
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
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config);
        $response = $requestHandler->execute($requestBlock->getXml());
        
        $this->assertXmlStringEqualsXmlString($xml, $response->getBody()->getContents());
        $history = $requestHandler->getHistory();
        $this->assertEquals(count($history), 1);
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::__construct
     * @covers Intacct\Xml\RequestHandler::execute
     */
    public function testMockRetry()
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
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config);
        $response = $requestHandler->execute($requestBlock->getXml());
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::__construct
     * @covers Intacct\Xml\RequestHandler::execute
     * @expectedException \GuzzleHttp\Exception\ServerException
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
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config);
        $requestHandler->execute($requestBlock->getXml());
    }
    
    /**
     * @covers Intacct\Xml\RequestHandler::__construct
     * @covers Intacct\Xml\RequestHandler::execute
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testMockDefaultNo524Retry()
    {
        $mock = new MockHandler([
            new Response(524),
        ]);
        
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
            'mock_handler' => $mock,
        ];
        
        $contentBlock = new ContentBlock();

        $requestBlock = new RequestBlock($config, $contentBlock);
        $requestHandler = new RequestHandler($config);
        $requestHandler->execute($requestBlock->getXml());
    }

}
