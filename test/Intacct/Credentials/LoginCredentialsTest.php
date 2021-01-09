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
 * @coversDefaultClass \Intacct\Credentials\LoginCredentials
 */
class LoginCredentialsTest extends \PHPUnit\Framework\TestCase
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

    public function testCredsFromConfig(): void
    {
        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setUserId('testuser');
        $config->setUserPassword('testpass');

        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('testcompany', $loginCreds->getCompanyId());
        $this->assertEquals('testuser', $loginCreds->getUserId());
        $this->assertEquals('testpass', $loginCreds->getPassword());
        $endpoint = $loginCreds->getSenderCredentials()->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertThat(
            $loginCreds->getSenderCredentials(),
            $this->isInstanceOf('Intacct\Credentials\SenderCredentials')
        );
    }

    public function testCredsWithEntityIdFromConfig(): void
    {
        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setEntityId('testentity');
        $config->setUserId('testuser');
        $config->setUserPassword('testpass');

        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('testcompany', $loginCreds->getCompanyId());
        $this->assertEquals('testentity', $loginCreds->getEntityId());
        $this->assertEquals('testuser', $loginCreds->getUserId());
        $this->assertEquals('testpass', $loginCreds->getPassword());
        $endpoint = $loginCreds->getSenderCredentials()->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertThat(
            $loginCreds->getSenderCredentials(),
            $this->isInstanceOf('Intacct\Credentials\SenderCredentials')
        );
    }

    public function testCredsFromEnv(): void
    {
        putenv('INTACCT_COMPANY_ID=envcompany');
        putenv('INTACCT_USER_ID=envuser');
        putenv('INTACCT_USER_PASSWORD=envuserpass');

        $creds = new LoginCredentials(new ClientConfig(), $this->senderCreds);

        $this->assertEquals('envcompany', $creds->getCompanyId());
        $this->assertNull($creds->getEntityId());
        $this->assertEquals('envuser', $creds->getUserId());
        $this->assertEquals('envuserpass', $creds->getPassword());
        $endpoint = $creds->getSenderCredentials()->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);

        putenv('INTACCT_COMPANY_ID');
        putenv('INTACCT_USER_ID');
        putenv('INTACCT_USER_PASSWORD');
    }

    public function testCredsWithEntityFromEnv(): void
    {
        putenv('INTACCT_COMPANY_ID=envcompany');
        putenv('INTACCT_ENTITY_ID=enventity');
        putenv('INTACCT_USER_ID=envuser');
        putenv('INTACCT_USER_PASSWORD=envuserpass');

        $creds = new LoginCredentials(new ClientConfig(), $this->senderCreds);

        $this->assertEquals('envcompany', $creds->getCompanyId());
        $this->assertEquals('enventity', $creds->getEntityId());
        $this->assertEquals('envuser', $creds->getUserId());
        $this->assertEquals('envuserpass', $creds->getPassword());
        $endpoint = $creds->getSenderCredentials()->getEndpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);

        putenv('INTACCT_COMPANY_ID');
        putenv('INTACCT_ENTITY_ID');
        putenv('INTACCT_USER_ID');
        putenv('INTACCT_USER_PASSWORD');
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
company_id = inicompanyid
user_id = iniuserid
user_password = iniuserpass
EOF;
        // TODO move this into vfs file stream and not temp folder
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('unittest');

        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('inicompanyid', $loginCreds->getCompanyId());
        $this->assertNull($loginCreds->getEntityId());
        $this->assertEquals('iniuserid', $loginCreds->getUserId());
        $this->assertEquals('iniuserpass', $loginCreds->getPassword());
    }

    public function testCredsWithEntityFromProfile(): void
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
[unittest]
company_id = inicompanyid
entity_id = inientityid
user_id = iniuserid
user_password = iniuserpass
EOF;
        // TODO move this into vfs file stream and not temp folder
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('unittest');

        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('inicompanyid', $loginCreds->getCompanyId());
        $this->assertEquals('inientityid', $loginCreds->getEntityId());
        $this->assertEquals('iniuserid', $loginCreds->getUserId());
        $this->assertEquals('iniuserpass', $loginCreds->getPassword());
    }

    public function testCredsFromArrayNoCompanyId(): void
    {
        $this->expectExceptionMessage("Required Company ID not supplied in config or env variable \"INTACCT_COMPANY_ID\"");
        $this->expectException(\InvalidArgumentException::class);

        $config = new ClientConfig();
        $config->setCompanyId('');
        $config->setUserId('testuser');
        $config->setUserPassword('testpass');

        new LoginCredentials($config, $this->senderCreds);
    }

    public function testCredsFromArrayNoUserId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Required User ID not supplied in config or env variable \"INTACCT_USER_ID\"");

        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setUserId('');
        $config->setUserPassword('testpass');

        new LoginCredentials($config, $this->senderCreds);
    }

    public function testCredsFromArrayNoUserPassword(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Required User Password not supplied in config or env variable \"INTACCT_USER_PASSWORD\"");

        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setUserId('testuser');
        $config->setUserPassword('');

        new LoginCredentials($config, $this->senderCreds);
    }
}
