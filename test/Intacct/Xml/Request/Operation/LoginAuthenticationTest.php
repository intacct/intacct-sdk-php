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

namespace Intacct\Xml\Request\Operation;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Xml\Request\Operation\LoginAuthentication
 */
class LoginAuthenticationTest extends \PHPUnit_Framework_TestCase
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

    public function testWriteXml()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<authentication>
    <login>
        <userid>testuser</userid>
        <companyid>testcompany</companyid>
        <password>testpass</password>
    </login>
</authentication>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $loginAuth = new LoginAuthentication($config);
        $loginAuth->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "company_id" key not supplied in params
     */
    public function testInvalidCompanyId()
    {
        $config = [
            'company_id' => null,
            'user_id' => 'testuser',
            'user_password' => 'testpass',
        ];
        
        new LoginAuthentication($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_id" key not supplied in params
     */
    public function testInvalidUserId()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => null,
            'user_password' => 'testpass',
        ];
        
        new LoginAuthentication($config);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_password" key not supplied in params
     */
    public function testInvalidUserPass()
    {
        $config = [
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => null,
        ];
        
        new LoginAuthentication($config);
    }
}
