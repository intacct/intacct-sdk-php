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
 * @coversDefaultClass \Intacct\Credentials\SenderCredentials
 */
class SenderCredentialsTest extends \PHPUnit\Framework\TestCase
{

    public function testCredsFromConfig(): void
    {
        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');
        $config->setEndpointUrl('https://unittest.intacct.com/ia/xml/xmlgw.phtml');

        $creds = new SenderCredentials($config);

        $this->assertEquals('testsenderid', $creds->getSenderId());
        $this->assertEquals('pass123!', $creds->getPassword());
        $this->assertEquals('https://unittest.intacct.com/ia/xml/xmlgw.phtml', (string)$creds->getEndpoint());
    }

    public function testCredsFromEnv(): void
    {
        putenv('INTACCT_SENDER_ID=envsender');
        putenv('INTACCT_SENDER_PASSWORD=envpass');

        $creds = new SenderCredentials(new ClientConfig());

        $this->assertEquals('envsender', $creds->getSenderId());
        $this->assertEquals('envpass', $creds->getPassword());
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', (string)$creds->getEndpoint());

        putenv('INTACCT_SENDER_ID');
        putenv('INTACCT_SENDER_PASSWORD');
    }

    public function testCredsNoSenderId(): void
    {
        $this->expectExceptionMessage("Required Sender ID not supplied in config or env variable \"INTACCT_SENDER_ID\"");
        $this->expectException(\InvalidArgumentException::class);

        $config = new ClientConfig();
        //$config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');

        new SenderCredentials($config);
    }

    public function testCredsNoSenderPassword(): void
    {
        $this->expectExceptionMessage("Required Sender Password not supplied in config or env variable \"INTACCT_SENDER_PASSWORD\"");
        $this->expectException(\InvalidArgumentException::class);

        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        //$config->setSenderPassword('pass123!');

        new SenderCredentials($config);
    }

    private function clearEnv(): string
    {
        $dir = sys_get_temp_dir() . '/.intacct';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    public function testCredsFromProfile(): void
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
[unittest]
sender_id = inisenderid
sender_password = inisenderpass
endpoint_url = https://unittest.intacct.com/ia/xml/xmlgw.phtml
EOF;
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('unittest');

        $senderCreds = new SenderCredentials($config);

        $this->assertEquals('inisenderid', $senderCreds->getSenderId());
        $this->assertEquals('inisenderpass', $senderCreds->getPassword());
        $this->assertEquals('https://unittest.intacct.com/ia/xml/xmlgw.phtml', (string)$senderCreds->getEndpoint());
    }

    public function testCredsFromProfileOverrideEndpoint(): void
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
[unittest]
sender_id = inisenderid
sender_password = inisenderpass
endpoint_url = https://unittest.intacct.com/ia/xmlgw.phtml
EOF;
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('unittest');
        $config->setEndpointUrl('https://somethingelse.intacct.com/ia/xml/xmlgw.phtml');

        $senderCreds = new SenderCredentials($config);

        $this->assertEquals('inisenderid', $senderCreds->getSenderId());
        $this->assertEquals('inisenderpass', $senderCreds->getPassword());
        $this->assertEquals('https://somethingelse.intacct.com/ia/xml/xmlgw.phtml', (string)$senderCreds->getEndpoint());
    }
}
