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

namespace Intacct\Credentials;

use Intacct\ClientConfig;

class Endpoint
{

    /** @var string */
    const DEFAULT_ENDPOINT = 'https://api.intacct.com/ia/xml/xmlgw.phtml';

    /** @var string */
    const ENDPOINT_URL_ENV_NAME = 'INTACCT_ENDPOINT_URL';

    /** @var string */
    const DOMAIN_NAME = 'intacct.com';

    const FULL_QUALIFIED_DOMAIN_NAME = self::DOMAIN_NAME . ".";

    /** @var string */
    private $url;

    /**
     * Endpoint constructor.
     *
     * @param ClientConfig $config
     */
    public function __construct(ClientConfig $config)
    {
        if (!$config->getEndpointUrl()) {
            $this->setUrl(getenv(static::ENDPOINT_URL_ENV_NAME));
        } else {
            $this->setUrl($config->getEndpointUrl());
        }
    }

    private function isDomainValid(string $hostName) {
         $checkMainDomain = "." . self::DOMAIN_NAME;
         $checkFQDNDomain = "." . self::FULL_QUALIFIED_DOMAIN_NAME;

         // if hostname is 1-1 for Main or FQDN, it is valid
         return (substr($hostName, -strlen($checkMainDomain)) === $checkMainDomain) ||
             (substr($hostName, -strlen($checkFQDNDomain)) === $checkFQDNDomain);

    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl();
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        if (!$url) {
            $url = self::DEFAULT_ENDPOINT;
        }
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException(
                'Endpoint URL is not a valid URL.'
            );
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (!$this->isDomainValid($host)) {
            throw new \InvalidArgumentException(
                'Endpoint URL is not a valid ' . self::DOMAIN_NAME . ' domain name.'
            );
        }

        $this->url = $url;
    }
}
