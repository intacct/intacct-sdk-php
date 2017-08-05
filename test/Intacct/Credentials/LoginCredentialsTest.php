<?php
/**
 * Copyright 2017 Sage Intacct, Inc.
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
    protected function setUp()
    {
        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');

        $this->senderCreds = new SenderCredentials($config);
    }

    public function testCredsFromConfig()
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

    private function clearEnv()
    {
        $dir = sys_get_temp_dir() . '/.intacct';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    /**
     * @todo move this into vfs file stream and not temp folder?
     */
    public function testCredsFromProfile()
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
[unittest]
company_id = inicompanyid
user_id = iniuserid
user_password = iniuserpass
EOF;
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = new ClientConfig();
        $config->setProfileName('unittest');

        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('inicompanyid', $loginCreds->getCompanyId());
        $this->assertEquals('iniuserid', $loginCreds->getUserId());
        $this->assertEquals('iniuserpass', $loginCreds->getPassword());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Required Company ID not supplied in config or env variable "INTACCT_COMPANY_ID"
     */
    public function testCredsFromArrayNoCompanyId()
    {
        $config = new ClientConfig();
        $config->setCompanyId('');
        $config->setUserId('testuser');
        $config->setUserPassword('testpass');

        new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Required User ID not supplied in config or env variable "INTACCT_USER_ID"
     */
    public function testCredsFromArrayNoUserId()
    {
        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setUserId('');
        $config->setUserPassword('testpass');

        new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Required User Password not supplied in config or env variable "INTACCT_USER_PASSWORD"
     */
    public function testCredsFromArrayNoUserPassword()
    {
        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setUserId('testuser');
        $config->setUserPassword('');

        new LoginCredentials($config, $this->senderCreds);
    }
}
