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
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Intacct\Credentials\ProfileCredentialProvider
 */
class ProfileCredentialProviderTest extends TestCase
{

    /** @var string */
    protected $ini;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp(): void
    {
        $this->ini = <<<EOF
[default]
sender_id = defsenderid
sender_password = defsenderpass
company_id = defcompanyid
user_id = defuserid
user_password = defuserpass
endpoint_url = https://unittest.intacct.com/ia/xmlgw.phtml

[unittest]
company_id = inicompanyid
user_id = iniuserid
user_password = iniuserpass

[entity]
company_id = inicompanyid
entity_id = inientityid
user_id = iniuserid
user_password = iniuserpass
EOF;
    }

    private function clearEnv(): string
    {
        $dir = sys_get_temp_dir() . '/.intacct';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    public function testGetCredentialsFromDefaultProfile(): void
    {
        $dir = $this->clearEnv();

        file_put_contents($dir . '/credentials.ini', $this->ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $loginCreds = ProfileCredentialProvider::getLoginCredentials($config);

        $this->assertEquals('defcompanyid', $loginCreds->getCompanyId());
        $this->assertNull($loginCreds->getEntityId());
        $this->assertEquals('defuserid', $loginCreds->getUserId());
        $this->assertEquals('defuserpass', $loginCreds->getUserPassword());

        $senderCreds = ProfileCredentialProvider::getSenderCredentials($config);

        $this->assertEquals('defsenderid', $senderCreds->getSenderId());
        $this->assertEquals('defsenderpass', $senderCreds->getSenderPassword());
        $this->assertEquals('https://unittest.intacct.com/ia/xmlgw.phtml', $senderCreds->getEndpointUrl());
    }

    public function testGetLoginCredentialsFromSpecificProfile(): void
    {
        $dir = $this->clearEnv();

        file_put_contents($dir . '/credentials.ini', $this->ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('unittest');

        $profileCreds = ProfileCredentialProvider::getLoginCredentials($config);

        $this->assertEquals('inicompanyid', $profileCreds->getCompanyId());
        $this->assertNull($profileCreds->getEntityId());
        $this->assertEquals('iniuserid', $profileCreds->getUserId());
        $this->assertEquals('iniuserpass', $profileCreds->getUserPassword());
    }

    public function testGetLoginCredentialsWithEntityFromSpecificProfile(): void
    {
        $dir = $this->clearEnv();

        file_put_contents($dir . '/credentials.ini', $this->ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('entity');

        $profileCreds = ProfileCredentialProvider::getLoginCredentials($config);

        $this->assertEquals('inicompanyid', $profileCreds->getCompanyId());
        $this->assertEquals('inientityid', $profileCreds->getEntityId());
        $this->assertEquals('iniuserid', $profileCreds->getUserId());
        $this->assertEquals('iniuserpass', $profileCreds->getUserPassword());
    }

    public function testGetLoginCredentialsFromNullProfile(): void
    {
        $config = new ClientConfig();
        $config->setProfileName('');

        $loginCreds = ProfileCredentialProvider::getLoginCredentials($config);

        $this->assertEquals('defcompanyid', $loginCreds->getCompanyId());
        $this->assertEquals('defuserid', $loginCreds->getUserId());
        $this->assertEquals('defuserpass', $loginCreds->getUserPassword());
    }

    public function testGetLoginCredentialsFromMissingIni(): void
    {
        $this->expectExceptionMessage("Cannot read credentials from file, \"notarealfile.ini\"");
        $this->expectException(InvalidArgumentException::class);

        $config = new ClientConfig();
        $config->setProfileFile('notarealfile.ini');

        ProfileCredentialProvider::getLoginCredentials($config);
    }

    public function testGetLoginCredentialsMissingDefault(): void
    {
        $this->expectExceptionMessage("Profile Name \"default\" not found in credentials file");
        $this->expectException(InvalidArgumentException::class);

        $dir = $this->clearEnv();
        $ini = <<<EOF
[notdefault]
sender_id = testsenderid
sender_password = testsenderpass
EOF;
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        ProfileCredentialProvider::getLoginCredentials($config);
    }
}
