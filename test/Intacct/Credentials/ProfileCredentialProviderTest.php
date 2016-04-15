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

namespace Intacct\Credentials;

use InvalidArgumentException;

class ProfileCredentialProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ProfileCredentialProvider
     */
    private $provider;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->provider = new ProfileCredentialProvider();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

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
     * @covers Intacct\Credentials\ProfileCredentialProvider::getSenderCredentials
     * @covers Intacct\Credentials\ProfileCredentialProvider::getIniProfileData
     * @covers Intacct\Credentials\ProfileCredentialProvider::getHomeDirProfile
     */
    public function testGetCredentialsFromDefaultProfile()
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
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
EOF;
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $config = [];
        $loginCreds = $this->provider->getLoginCredentials($config);
        $expectedLogin = [
            'company_id' => 'defcompanyid',
            'user_id' => 'defuserid',
            'user_password' => 'defuserpass',
        ];
        $this->assertEquals($expectedLogin, $loginCreds);

        $senderCreds = $this->provider->getSenderCredentials($config);
        $expectedSender = [
            'sender_id' => 'defsenderid',
            'sender_password' => 'defsenderpass',
            'endpoint_url' => 'https://unittest.intacct.com/ia/xmlgw.phtml',
        ];
        $this->assertEquals($expectedSender, $senderCreds);
    }

    /**
     * @covers Intacct\Credentials\ProfileCredentialProvider::getLoginCredentials
     * @covers Intacct\Credentials\ProfileCredentialProvider::getIniProfileData
     */
    public function testGetLoginCredentialsFromSpecificProfile()
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
[default]
sender_id = defsenderid
sender_password = defsenderpass
company_id = defcompanyid
user_id = defuserid
user_password = defuserpass

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
        $profileCreds = $this->provider->getLoginCredentials($config);
        $expected = [
            'company_id' => 'inicompanyid',
            'user_id' => 'iniuserid',
            'user_password' => 'iniuserpass',
        ];
        $this->assertEquals($expected, $profileCreds);
    }

    /**
     * @covers Intacct\Credentials\ProfileCredentialProvider::getLoginCredentials
     * @covers Intacct\Credentials\ProfileCredentialProvider::getIniProfileData
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "profile_name" key not supplied in params
     */
    public function testGetLoginCredentialsFromNullProfile()
    {
        $config = [
            'profile_name' => '',
        ];
        $this->provider->getLoginCredentials($config);
    }

    /**
     * @covers Intacct\Credentials\ProfileCredentialProvider::getLoginCredentials
     * @covers Intacct\Credentials\ProfileCredentialProvider::getIniProfileData
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Cannot read credentials from file, "notarealfile.ini"
     */
    public function testGetLoginCredentialsFromMissingIni()
    {
        $config = [
            'profile_file' => 'notarealfile.ini'
        ];
        $this->provider->getLoginCredentials($config);
    }

    /**
     * @covers Intacct\Credentials\ProfileCredentialProvider::getLoginCredentials
     * @covers Intacct\Credentials\ProfileCredentialProvider::getIniProfileData
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Profile name "default" not found in credentials file
     */
    public function testGetLoginCredentialsMissingDefault()
    {
        $dir = $this->clearEnv();
        $ini = <<<EOF
[notdefault]
sender_id = testsenderid
sender_password = testsenderpass
EOF;
        file_put_contents($dir . '/credentials.ini', $ini);
        putenv('HOME=' . dirname($dir));

        $this->provider->getLoginCredentials();
    }

}
