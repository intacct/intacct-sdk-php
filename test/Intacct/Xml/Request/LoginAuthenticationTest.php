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

namespace Intacct\Xml\Request;

use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Xml\Request\LoginAuthentication
 */
class LoginAuthenticationTest extends \PHPUnit\Framework\TestCase
{

    public function testWriteXml(): void
    {
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

        $loginAuth = new LoginAuthentication('testuser', 'testcompany', 'testpass');
        $loginAuth->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlWithEntity(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<authentication>
    <login>
        <userid>testuser</userid>
        <companyid>testcompany</companyid>
        <password>testpass</password>
        <locationid>testentity</locationid>
    </login>
</authentication>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $loginAuth = new LoginAuthentication('testuser', 'testcompany', 'testpass', 'testentity');
        $loginAuth->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlWithEmptyEntity(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<authentication>
    <login>
        <userid>testuser</userid>
        <companyid>testcompany</companyid>
        <password>testpass</password>
        <locationid/>
    </login>
</authentication>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $loginAuth = new LoginAuthentication('testuser', 'testcompany', 'testpass', '');
        $loginAuth->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testInvalidCompanyId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Company ID is required and cannot be blank");

        new LoginAuthentication('testuser', '', 'testpass');
    }

    public function testInvalidUserId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("User ID is required and cannot be blank");

        new LoginAuthentication('', 'testcompany', 'testpass');
    }

    public function testInvalidUserPass(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("User Password is required and cannot be blank");

        new LoginAuthentication('testuser', 'testcompany', '');
    }
}
