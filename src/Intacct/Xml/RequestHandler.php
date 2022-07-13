<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

use GuzzleHttp\Exception\RequestException;
use Intacct\ClientConfig;
use Intacct\Credentials\Endpoint;
use Intacct\Credentials\SessionCredentials;
use Intacct\Functions\FunctionInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Intacct\RequestConfig;
use Psr\Http\Message\ResponseInterface;

class RequestHandler
{
    
    /** @var string */
    const VERSION = '3.2.0';

    /** @var ClientConfig */
    private $clientConfig;

    /**
     * @return ClientConfig
     */
    public function getClientConfig(): ClientConfig
    {
        return $this->clientConfig;
    }

    /**
     * @param ClientConfig $clientConfig
     */
    public function setClientConfig(ClientConfig $clientConfig)
    {
        $this->clientConfig = $clientConfig;
    }

    /** @var RequestConfig */
    private $requestConfig;

    /**
     * @return RequestConfig
     */
    public function getRequestConfig(): RequestConfig
    {
        return $this->requestConfig;
    }

    /**
     * @param RequestConfig $requestConfig
     */
    public function setRequestConfig(RequestConfig $requestConfig)
    {
        $this->requestConfig = $requestConfig;
    }

    /** @var string */
    private $endpointUrl;

    /**
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return $this->endpointUrl;
    }

    /**
     * @param string $endpointUrl
     */
    public function setEndpointUrl(string $endpointUrl)
    {
        $this->endpointUrl = $endpointUrl;
    }

    /** @var array */
    protected $history = [];

    /**
     * @return array
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    /**
     * @param array $history
     */
    protected function setHistory(array $history)
    {
        $this->history = $history;
    }

    /**
     * RequestHandler constructor.
     *
     * @param ClientConfig $clientConfig
     * @param RequestConfig $requestConfig
     */
    public function __construct(ClientConfig $clientConfig, RequestConfig $requestConfig)
    {
        if ($clientConfig->getEndpointUrl()) {
            $this->setEndpointUrl($clientConfig->getEndpointUrl());
        } else {
            $this->setEndpointUrl(new Endpoint($clientConfig));
        }

        $this->setClientConfig($clientConfig);

        $this->setRequestConfig($requestConfig);
    }

    /**
     * @param FunctionInterface[] $content
     * @return OnlineResponse
     */
    public function executeOnline(array $content): OnlineResponse
    {
        if ($this->getRequestConfig()->getPolicyId()) {
            $this->getRequestConfig()->setPolicyId('');
        }

        $requestBlock = new RequestBlock($this->getClientConfig(), $this->getRequestConfig(), $content);
        $client = $this->execute($requestBlock->writeXml());

        $body = $client->getBody();
        $body->rewind();
        $response = new OnlineResponse($body->getContents());

        return $response;
    }

    /**
     * @param FunctionInterface[] $content
     * @return OfflineResponse
     */
    public function executeOffline(array $content): OfflineResponse
    {
        if (!$this->getRequestConfig()->getPolicyId()) {
            throw new \InvalidArgumentException(
                'Required Policy ID not supplied in config for offline request'
            );
        }

        if (
            $this->getClientConfig()->getLogger()
            && (
                $this->getClientConfig()->getSessionId()
                || $this->getClientConfig()->getCredentials() instanceof SessionCredentials
            )
        ) {
            // Log warning if using session ID for offline execution
            $this->getClientConfig()->getLogger()->warning(
                'Offline execution sent to Sage Intacct using Session-based credentials. ' .
                'Use Login-based credentials instead to avoid session timeouts.'
            );
        }

        $requestBlock = new RequestBlock($this->getClientConfig(), $this->getRequestConfig(), $content);
        $client = $this->execute($requestBlock->writeXml());

        $body = $client->getBody();
        $body->rewind();
        $response = new OfflineResponse($body->getContents());

        return $response;
    }

    /**
     * @param \XMLWriter $xml
     * @return ResponseInterface
     */
    private function execute(\XMLWriter $xml): ResponseInterface
    {
        //this is used for retry logic
        $calls = [];
        $decider = function ($retries, $request, $response, $error) use (&$calls) {
            $calls[] = func_get_args();
            
            if (count($calls) > $this->getRequestConfig()->getMaxRetries()) {
                return false;
            }
            
            if ($error instanceof \GuzzleHttp\Exception\ServerException) {
                //retry if receiving http 5xx error codes
                $response = $error->getResponse();
                if (
                    in_array(
                        $response->getStatusCode(),
                        $this->getRequestConfig()->getNoRetryServerErrorCodes()
                    ) === true
                ) {
                    return false;
                } else {
                    return true;
                }
            }
            
            //do not retry otherwise
            return false;
        };
        
        //setup the handler
        if ($this->getClientConfig()->getMockHandler() instanceof MockHandler) {
            $handler = HandlerStack::create($this->getClientConfig()->getMockHandler());
        } else {
            $handler = HandlerStack::create();
        }
        
        //add the retry logic before the http_errors middleware
        $handler->before('http_errors', Middleware::retry($decider), 'retry_logic');

        // replace the http_errors middleware with our own to process XML responses before HTTP errors
        $handler->before(
            'http_errors',
            function (callable $handler) {
                return function ($request, array $options) use ($handler) {
                    return $handler($request, $options)->then(
                        function (ResponseInterface $response) use ($request, $handler) {
                            $code = $response->getStatusCode();
                            if ($code < 400) {
                                return $response;
                            }
                            $contentType = trim($response->getHeaderLine('content-type'));
                            if (
                                substr($contentType, 0, 8) === 'text/xml' ||
                                substr($contentType, 0, 15) == 'application/xml'
                            ) {
                                return $response;
                            }
                            throw RequestException::create($request, $response);
                        }
                    );
                };
            },
            'xml_and_http_errors'
        );
        $handler->remove('http_errors');

        //push the history middleware to the top of the stack
        $handler->push(Middleware::history($this->history));

        if ($this->getClientConfig()->getLogger()) {
            //push the logger middleware to the top of the stack
            $handler->push(
                Middleware::log(
                    $this->getClientConfig()->getLogger(),
                    $this->getClientConfig()->getLogMessageFormatter(),
                    $this->getClientConfig()->getLogLevel()
                )
            );
        }
        
        $client = new Client([
            'handler' => $handler,
        ]);

        $options = [
            'body' => $xml->flush(),
            'headers' => [
                'content-type' => 'application/xml',
                'Accept-Encoding' => 'gzip,deflate',
                'User-Agent' => "intacct-sdk-php-client/" . static::VERSION,
            ],
            'timeout' => $this->requestConfig->getMaxTimeout()
        ];
        
        $response = $client->post($this->getEndpointUrl(), $options);

        return $response;
    }
}
