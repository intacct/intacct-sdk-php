<?php
/**
 * Copyright 2016 Intacct Corporation.
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

namespace Intacct\Tests\Credentials;

use Intacct\Credentials\SenderCredentials;
use Exception;

class SenderCredentialsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @covers Intacct\Credentials\SenderCredentials::getSenderId
     * @covers Intacct\Credentials\SenderCredentials::getPassword
     * @covers Intacct\Credentials\SenderCredentials::getEndpoint
     */
    public function testCredsFromArray()
    {
        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'endpoint_url' => 'https://unittest.intacct.com/ia/xmlgw.phtml',
        ];
        $creds = new SenderCredentials($config);
        
        $this->assertEquals('testsenderid', $creds->getSenderId());
        $this->assertEquals('pass123!', $creds->getPassword());
        $this->assertEquals('https://unittest.intacct.com/ia/xmlgw.phtml', $creds->getEndpoint());
    }

    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @covers Intacct\Credentials\SenderCredentials::getSenderId
     * @covers Intacct\Credentials\SenderCredentials::getPassword
     * @covers Intacct\Credentials\SenderCredentials::getEndpoint
     */
    public function testCredsFromEnv()
    {
        putenv('INTACCT_SENDER_ID=envsender');
        putenv('INTACCT_SENDER_PASSWORD=envpass');

        $creds = new SenderCredentials();

        $this->assertEquals('envsender', $creds->getSenderId());
        $this->assertEquals('envpass', $creds->getPassword());
        //TODO fix this -- $this->assertEquals('https://api.intacct.com/ia/xmlgw.phtml', $creds->getEndpoint());
        
        putenv('INTACCT_SENDER_ID');
        putenv('INTACCT_SENDER_PASSWORD');
    }
    
    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Required "sender_id" key not supplied in params or env variable "INTACCT_SENDER_ID"
     */
    public function testCredsNoSenderId()
    {
        $config = [
            //'sender_id' => null,
            'sender_password' => 'pass123!',
        ];
        new SenderCredentials($config);
    }
    
    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Required "sender_password" key not supplied in params or env variable "INTACCT_SENDER_PASSWORD"
     */
    public function testCredsNoSenderPassword()
    {
        $config = [
            'sender_id' => 'testsenderid',
            //'sender_password' => null,
        ];
        new SenderCredentials($config);
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
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @covers Intacct\Credentials\SenderCredentials::getSenderId
     * @covers Intacct\Credentials\SenderCredentials::getPassword
     * @covers Intacct\Credentials\SenderCredentials::getEndpoint
     */
    public function testCredsFromProfile()
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

        $config = [
            'profile_name' => 'unittest',
        ];
        $senderCreds = new SenderCredentials($config);

        $this->assertEquals('inisenderid', $senderCreds->getSenderId());
        $this->assertEquals('inisenderpass', $senderCreds->getPassword());
        $this->assertEquals('https://unittest.intacct.com/ia/xmlgw.phtml', $senderCreds->getEndpoint());
    }

    /**
     * @covers Intacct\Credentials\SenderCredentials::__construct
     * @covers Intacct\Credentials\SenderCredentials::getSenderId
     * @covers Intacct\Credentials\SenderCredentials::getPassword
     * @covers Intacct\Credentials\SenderCredentials::getEndpoint
     */
    public function testCredsFromProfileOverrideEndpoint()
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

        $config = [
            'profile_name' => 'unittest',
            'endpoint_url' => 'https://somethingelse.intacct.com/ia/xmlgw.phtml'
        ];
        $senderCreds = new SenderCredentials($config);

        $this->assertEquals('inisenderid', $senderCreds->getSenderId());
        $this->assertEquals('inisenderpass', $senderCreds->getPassword());
        $this->assertEquals('https://somethingelse.intacct.com/ia/xmlgw.phtml', $senderCreds->getEndpoint());
    }

}
