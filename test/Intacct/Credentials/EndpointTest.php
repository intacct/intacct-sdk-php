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

/**
 * @coversDefaultClass \Intacct\Endpoint
 */
class EndpointTest extends \PHPUnit\Framework\TestCase
{
    public function testDefaultEndpoint(): void
    {
        $endpoint = new Endpoint(new ClientConfig());
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getUrl());
    }

    public function testEnvEndpoint(): void
    {
        putenv('INTACCT_ENDPOINT_URL=https://envunittest.intacct.com/ia/xml/xmlgw.phtml');

        $endpoint = new Endpoint(new ClientConfig());
        $this->assertEquals('https://envunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertEquals('https://envunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getUrl());

        putenv('INTACCT_ENDPOINT_URL');
    }

    public function testArrayEndpoint(): void
    {
        $config = new ClientConfig();
        $config->setEndpointUrl('https://arrayunittest.intacct.com/ia/xml/xmlgw.phtml');

        $endpoint = new Endpoint($config);
        $this->assertEquals('https://arrayunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertEquals('https://arrayunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getUrl());
    }

    public function testNullEndpoint(): void
    {
        $config = new ClientConfig();
        $config->setEndpointUrl('');

        $endpoint = new Endpoint($config);
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
    }

    public function testInvalidUrlEndpoint(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Endpoint URL is not a valid URL.');

        $config = new ClientConfig();
        $config->setEndpointUrl('invalidurl');

        new Endpoint($config);
    }

    public function testInvalidIntacctUrlEndpoint(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Endpoint URL is not a valid intacct.com domain name.');

        $config = new ClientConfig();
        $config->setEndpointUrl('https://api.example.com/xmlgw.phtml');

        new Endpoint($config);
    }

    public function testFQDNUrlEndpoint(): void
    {
        $config = new ClientConfig();
        $config->setEndpointUrl("https://api.intacct.com./ia/xml/xmlgw.phtml");
        $endpoint = new Endpoint($config);
        $this->assertEquals('https://api.intacct.com./ia/xml/xmlgw.phtml', $endpoint);
    }
}
