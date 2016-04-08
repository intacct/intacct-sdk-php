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

namespace Intacct\Xml;

use Intacct\IntacctClient;
use Intacct\Xml\Request\Control;
use Intacct\Xml\Request\Operation;
use Intacct\Xml\Request\Operation\Content;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use XMLWriter;
use InvalidArgumentException;

class Request
{

    /**
     * 
     * @var string
     */
    const XML_VERSION = '1.0';
    
    /**
     * 
     * @var string
     */
    const REQUEST_CONTENT_TYPE = 'x-intacct-xml-request';

    /**
     *
     * @var string
     */
    protected $encoding;

    /**
     *
     * @var string
     */
    protected $endpointURL;
    
    /**
     *
     * @var bool
     */
    protected $verifySSL;
    
    /**
     * 
     * @var bool
     */
    protected $userAgentDetail;
    
    /**
     * 
     * @var MockHandler
     */
    protected $mockHandler;
    
    /**
     *
     * @var array
     */
    protected $history = [];

    /**
     *
     * @var int
     */
    protected $maxRetries;
    
    /**
     * 
     * @var array
     */
    protected $noRetryServerErrorCodes;

    /**
     *
     * @var Control
     */
    protected $control;

    /**
     *
     * @var Operation
     */
    protected $operation;

    /**
     * 
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params, Content $content)
    {
        $defaults = [
            'encoding' => 'UTF-8',
            'endpoint_url' => null,
            'verify_ssl' => true,
            'mock_handler' => null,
            'max_retries' => 5,
            'no_retry_server_error_codes' => [
                524, //CDN cut connection, Intacct is still processing the request
            ],
        ];
        $config = array_merge($defaults, $params);

        if (!in_array($config['encoding'], mb_list_encodings())) {
            throw new InvalidArgumentException('Requested encoding is not supported');
        }
        $this->encoding = $config['encoding'];
        $this->endpointURL = $config['endpoint_url'];
        $this->verifySSL = $config['verify_ssl'];
        $this->mockHandler = $config['mock_handler'];
        $this->setMaxRetries($config['max_retries']);
        $this->setNoRetryServerErrorCodes($config['no_retry_server_error_codes']);
        
        $this->control = new Control($config);
        $this->operation = new Operation($config, $content);
    }

    /**
     * 
     * @return XMLWriter
     */
    public function getXml()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(false);
        $xml->startDocument(self::XML_VERSION, $this->encoding);
        $xml->startElement('request');

        $this->control->getXml($xml); //create control block

        $this->operation->getXml($xml); //create operation block

        $xml->endElement(); //request

        return $xml;
    }
    
    /**
     * 
     * @return string
     */
    protected function getUserAgent()
    {
        $userAgent = 'intacct-api-php-client/' . IntacctClient::VERSION;

        return $userAgent;
    }
    
    /**
     * 
     * @return bool
     */
    public function getVerifySSL()
    {
        return $this->verifySSL;
    }
    
    /**
     * 
     * @return array
     */
    public function getHistory()
    {
        return $this->history;
    }
    
    private function setMaxRetries($maxRetries)
    {
        if (!is_int($maxRetries)) {
            throw new InvalidArgumentException(
                'max retries not valid int type'
            );
        }
        if ($maxRetries < 0) {
            throw new InvalidArgumentException(
                'max retries must be zero or greater'
            );
        }
        $this->maxRetries = $maxRetries;
    }
    
    public function getMaxRetries()
    {
        return $this->maxRetries;
    }
    
    private function setNoRetryServerErrorCodes(array $errorCodes)
    {
        foreach($errorCodes as $errorCode) {
            if (!is_int($errorCode)) {
                throw new InvalidArgumentException(
                    'no retry server error code is not valid int type'
                );
            }
            if ($errorCode < 500 || $errorCode > 599) {
                throw new InvalidArgumentException(
                    'no retry server error code must be between 500-599'
                );
            }
        }
        $this->noRetryServerErrorCodes = $errorCodes;
    }
    
    public function getNoRetryServerErrorCodes()
    {
        return $this->noRetryServerErrorCodes;
    }

    /**
     * 
     * @return ResponseInterface
     */
    public function execute()
    {
        //this is used for retry logic
        $calls = [];
        $decider = function ($retries, $request, $response, $error) use (&$calls) {
            $calls[] = func_get_args();
            
            if (count($calls) > $this->maxRetries) {
                return false;
            }
            
            if ($error instanceof \GuzzleHttp\Exception\ServerException) {
                //retry if receiving http 5xx error codes
                $response = $error->getResponse();
                if (in_array($response->getStatusCode(), $this->noRetryServerErrorCodes) === true) {
                    return false;
                } else {
                    return true;
                }
            }
            
            //do not retry otherwise
            return false;
        };
        
        //setup the handler
        if ($this->mockHandler instanceof MockHandler) {
            $handler = HandlerStack::create($this->mockHandler);
        } else {
            $handler = HandlerStack::create();
        }
        
        //add the retry logic before the http_errors middleware
        $handler->before('http_errors', Middleware::retry($decider), 'retry_logic');
        
        //push the history middleware to the top of the stack
        $handler->push(Middleware::history($this->history));
        
        $client = new Client([
            'handler' => $handler,
        ]);
        
        $xml = $this->getXml();

        $options = [
            'body' => $xml->flush(),
            'verify' => $this->getVerifySSL(),
            'headers' => [
                'content-type' => self::REQUEST_CONTENT_TYPE,
                'User-Agent' => $this->getUserAgent(),
            ]
        ];
        
        $response = $client->post($this->endpointURL, $options);

        return $response;
    }

}
