<?php
/**
 * Copyright 2017 Intacct Corporation.
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

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Credentials\LoginCredentials
 */
class LoginCredentialsTest extends \PHPUnit_Framework_TestCase
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
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
        ];
        $this->senderCreds = new SenderCredentials($config);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    
    public function testCredsFromArray()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('testcompany', $loginCreds->getCompanyId());
        $this->assertEquals('testuser', $loginCreds->getUserId());
        $this->assertEquals('testpass', $loginCreds->getPassword());
        $endpoint = $loginCreds->getEndpoint();
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

        $config = [
            'profile_name' => 'unittest',
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);

        $this->assertEquals('inicompanyid', $loginCreds->getCompanyId());
        $this->assertEquals('iniuserid', $loginCreds->getUserId());
        $this->assertEquals('iniuserpass', $loginCreds->getPassword());
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "company_id" key not supplied in params or env variable "INTACCT_COMPANY_ID"
     */
    public function testCredsFromArrayNoCompanyId()
    {
        $config = [
            'company_id' => null,
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_id" key not supplied in params or env variable "INTACCT_USER_ID"
     */
    public function testCredsFromArrayNoUserId()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => null,
            'user_password' => 'testpass',
        ];
        new LoginCredentials($config, $this->senderCreds);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_password" key not supplied in params or env variable "INTACCT_USER_PASSWORD"
     */
    public function testCredsFromArrayNoUserPassword()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => null,
        ];
        new LoginCredentials($config, $this->senderCreds);
    }
    
    public function testGetMockHandler()
    {
        $response = new Response(200);
        $mock = new MockHandler([
            $response,
        ]);
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
            'mock_handler' => $mock,
        ];
        $loginCreds = new LoginCredentials($config, $this->senderCreds);
        $this->assertThat($loginCreds->getMockHandler(), $this->isInstanceOf('GuzzleHttp\Handler\MockHandler'));
    }
}
