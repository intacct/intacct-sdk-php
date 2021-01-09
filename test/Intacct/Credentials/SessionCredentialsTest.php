<?php
/**
 * Copyright 2021 Sage Intacct, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Credentials;

use Intacct\ClientConfig;

/**
 * @coversDefaultClass \Intacct\Credentials\SessionCredentials
 */
class SessionCredentialsTest extends \PHPUnit\Framework\TestCase
{

    /**
     *
     * @var SenderCredentials
     */
    protected $senderCreds;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp(): void
    {
        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');

        $this->senderCreds = new SenderCredentials($config);
    }

    public function testCredsFromArray(): void
    {
        $config = new ClientConfig();
        $config->setSessionId('faKEsesSiOnId..');
        $config->setEndpointUrl('https://p1.intacct.com/ia/xml/xmlgw.phtml');

        $sessionCreds = new SessionCredentials($config, $this->senderCreds);

        $this->assertEquals('faKEsesSiOnId..', $sessionCreds->getSessionId());
        $endpoint = $sessionCreds->getEndpoint();
        $this->assertEquals('https://p1.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getUrl());
        $this->assertThat(
            $sessionCreds->getSenderCredentials(),
            $this->isInstanceOf('Intacct\Credentials\SenderCredentials')
        );
    }

    public function testCredsFromArrayNoEndpoint(): void
    {
        $config = new ClientConfig();
        $config->setSessionId('faKEsesSiOnId..');
        $config->setEndpointUrl('');

        $sessionCreds = new SessionCredentials($config, $this->senderCreds);

        $endpoint = $sessionCreds->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getUrl());
    }

    public function testCredsFromArrayNoSession(): void
    {
        $this->expectExceptionMessage("Required Session ID not supplied in config");
        $this->expectException(\InvalidArgumentException::class);

        $config = new ClientConfig();
        $config->setSessionId('');

        new SessionCredentials($config, $this->senderCreds);
    }
}
