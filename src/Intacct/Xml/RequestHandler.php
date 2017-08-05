<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

use Intacct\Content;
use Intacct\Logging\MessageFormatter;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use InvalidArgumentException;
use XMLWriter;

class RequestHandler
{
    
    /** @var string */
    const VERSION = '1.0';

    /** @var string */
    const REQUEST_CONTENT_TYPE = 'x-intacct-xml-request';

    /** @var string */
    protected $endpointURL;
    
    /** @var bool */
    protected $verifySSL;

    /** @var MockHandler */
    protected $mockHandler;
    
    /** @var array */
    protected $history = [];

    /** @var int */
    protected $maxRetries;
    
    /** @var array */
    protected $noRetryServerErrorCodes;

    /** @var LoggerInterface */
    protected $logger;

    /** @var MessageFormatter */
    protected $logMessageFormat;

    /** @var int */
    protected $logLevel;

    /**
     * Initializes the class with the given parameters.
     *
     * The constructor accepts the following options:
     *
     * - `encoding` (string, default=string "UTF-8") Encoding to use
     * - `endpoint_url` (string) Endpoint URL
     * - `logger` (Psr\Log\LoggerInterface)
     * - `log_formatter` (Intacct\Logging\MessageFormatter) Log formatter
     * - `log_level` (int, default=int(400)) Log level
     * - `max_retries` (int, default=int(5)) Max number of retries
     * - `no_retry_server_error_codes` (int[], default=array(524)) HTTP server error codes to abort
     * retrying if one occurs
     * - `verify_ssl` (bool, default=bool(true)) Verify SSL certificate of response
     * - `mock_handler` (GuzzleHttp\Handler\MockHandler) Mock handler for unit tests
     *
     * @param array $params RequestHandler configuration options
     */
    public function __construct(array $params)
    {
        $defaults = [
            'encoding' => 'UTF-8',
            'endpoint_url' => null,
            'logger' => null,
            'log_formatter' => new MessageFormatter(MessageFormatter::CLF . MessageFormatter::DEBUG),
            'log_level' => LogLevel::DEBUG,
            'mock_handler' => null,
            'max_retries' => 5,
            'no_retry_server_error_codes' => [
                524, //CDN cut connection, Intacct is still processing the request
            ],
            'verify_ssl' => true,
        ];
        $config = array_merge($defaults, $params);

        $this->endpointURL = $config['endpoint_url'];
        $this->verifySSL = $config['verify_ssl'];
        $this->mockHandler = $config['mock_handler'];
        $this->setMaxRetries($config['max_retries']);
        $this->setNoRetryServerErrorCodes($config['no_retry_server_error_codes']);
        if ($config['logger']) {
            $this->setLogger($config['logger']);
        }
        $this->setLogMessageFormatter($config['log_formatter']);
        $this->setLogLevel($config['log_level']);
    }
    
    /**
     * Get user agent to use in the HTTP headers
     *
     * @return string
     */
    protected function getUserAgent()
    {
        $userAgent = 'intacct-api-php-client/' . RequestHandler::VERSION;

        return $userAgent;
    }
    
    /**
     * Get verify SSL
     *
     * @return bool
     */
    public function getVerifySSL()
    {
        return $this->verifySSL;
    }
    
    /**
     * Get history array
     *
     * @return array
     */
    public function getHistory()
    {
        return $this->history;
    }
    
    /**
     * Set max retries
     *
     * @param int $maxRetries
     * @throws InvalidArgumentException
     */
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
    
    /**
     * Get max retries
     *
     * @return int
     */
    public function getMaxRetries()
    {
        return $this->maxRetries;
    }
    
    /**
     * Set no retry server error codes
     *
     * @param array $errorCodes
     * @throws InvalidArgumentException
     */
    private function setNoRetryServerErrorCodes(array $errorCodes)
    {
        foreach ($errorCodes as $errorCode) {
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

    /**
     * Get no retry server error codes
     *
     * @return array
     */
    public function getNoRetryServerErrorCodes()
    {
        return $this->noRetryServerErrorCodes;
    }

    /**
     * Set logger
     *
     * @param LoggerInterface $logger
     */
    private function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set log message formatter
     *
     * @param MessageFormatter $formatter
     */
    private function setLogMessageFormatter(MessageFormatter $formatter)
    {
        $this->logMessageFormat = $formatter;
    }

    /**
     * Set log level
     *
     * @param int $logLevel
     */
    private function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;
    }

    /**
     * Execute a request synchronously
     *
     * @param array $params
     * @param Content $contentBlock
     *
     * @return SynchronousResponse
     */
    public function executeSynchronous(array $params, Content $contentBlock)
    {
        unset($params['policy_id']);

        $requestBlock = new RequestBlock($params, $contentBlock);

        $client = $this->execute($requestBlock->writeXml());

        $body = $client->getBody();
        $body->rewind();
        $response = new SynchronousResponse($body->getContents());

        return $response;
    }

    /**
     * Execute a request asynchronously with a policy ID
     *
     * @param array $params
     * @param Content $contentBlock
     *
     * @return AsynchronousResponse
     */
    public function executeAsynchronous(array $params, Content $contentBlock)
    {
        $defaults = [
            'policy_id' => null,
        ];
        $config = array_merge($defaults, $params);

        if (!isset($params['policy_id'])) {
            throw new InvalidArgumentException(
                'Required "policy_id" key not supplied in params for asynchronous request'
            );
        }

        $requestBlock = new RequestBlock($config, $contentBlock);
        $client = $this->execute($requestBlock->writeXml());

        $body = $client->getBody();
        $body->rewind();
        $response = new AsynchronousResponse($body->getContents());

        return $response;
    }

    /**
     * Execute an XML request to Intacct
     *
     * @param XMLWriter $xml
     * @return ResponseInterface
     */
    private function execute($xml)
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

        if ($this->logger) {
            //push the logger middleware to the top of the stack
            $handler->push(Middleware::log($this->logger, $this->logMessageFormat, $this->logLevel));
        }
        
        $client = new Client([
            'handler' => $handler,
        ]);

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
