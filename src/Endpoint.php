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

namespace Intacct;

use InvalidArgumentException;

class Endpoint
{

    /** @var string */
    const DEFAULT_ENDPOINT = 'https://api.intacct.com/ia/xml/xmlgw.phtml';
    
    /** @var string */
    const ENDPOINT_URL_ENV_NAME = 'INTACCT_ENDPOINT_URL';
    
    /** @var string */
    const DOMAIN_NAME = 'intacct.com';

    /** @var string */
    private $endpoint;
    
    /** @var bool */
    private $verifySSL;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $endpoint_url Endpoint URL
     *      @var bool $verify_ssl Verify SSL certificate of response, default=true
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'endpoint_url' => getenv(static::ENDPOINT_URL_ENV_NAME),
            'verify_ssl' => true,
        ];
        $config = array_merge($defaults, $params);
        
        $this->setEndpoint($config['endpoint_url']);
        $this->setVerifySSL($config['verify_ssl']);
    }
    
    /** @return string */
    public function __toString()
    {
        return $this->endpoint;
    }

    /**
     * Get the endpoint URL
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set the endpoint URL
     *
     * @param string $endpoint Endpoint URL
     * @throws InvalidArgumentException
     */
    private function setEndpoint($endpoint)
    {
        if (!$endpoint) {
            $endpoint = self::DEFAULT_ENDPOINT;
        }
        if (!is_string($endpoint)) {
            throw new InvalidArgumentException(
                'endpoint_url is not a valid string.'
            );
        }
        if (filter_var($endpoint, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(
                'endpoint_url is not a valid URL.'
            );
        }
        $host = parse_url($endpoint, PHP_URL_HOST);
        $len = strlen(self::DOMAIN_NAME);
        if (substr($host, -$len) !== self::DOMAIN_NAME) {
            throw new InvalidArgumentException(
                'endpoint_url is not a valid ' . self::DOMAIN_NAME . ' domain name.'
            );
        }

        $this->endpoint = $endpoint;
    }
    
    /**
     * Set verify SSL
     *
     * @param bool $verifySSL Verify SSL
     * @throws InvalidArgumentException
     */
    private function setVerifySSL($verifySSL)
    {
        if (!is_bool($verifySSL)) {
            throw new InvalidArgumentException(
                'verify_ssl is not a valid boolean type'
            );
        }
        $this->verifySSL = $verifySSL;
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
}
