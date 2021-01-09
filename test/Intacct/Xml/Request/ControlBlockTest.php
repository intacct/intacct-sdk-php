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

namespace Intacct\Xml\Request;

use Intacct\ClientConfig;
use Intacct\RequestConfig;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Xml\Request\ControlBlock
 */
class ControlBlockTest extends \PHPUnit\Framework\TestCase
{

    public function testWriteXmlDefaults(): void
    {
        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('unittest');

        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<control>
    <senderid>testsenderid</senderid>
    <password>pass123!</password>
    <controlid>unittest</controlid>
    <uniqueid>false</uniqueid>
    <dtdversion>3.0</dtdversion>
    <includewhitespace>false</includewhitespace>
</control>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $controlBlock = new ControlBlock($clientConfig, $requestConfig);
        $controlBlock->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlInvalidSenderId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Sender ID is required and cannot be blank");

        $clientConfig = new ClientConfig();
        //$clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');

        new ControlBlock($clientConfig, new RequestConfig());
    }

    public function testWriteXmlInvalidSenderPassword(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Sender Password is required and cannot be blank");

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        //$clientConfig->setSenderPassword('pass123!');

        new ControlBlock($clientConfig, new RequestConfig());
    }

    public function testWriteXmlDefaultsOverride(): void
    {
        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('testcontrol');
        $requestConfig->setUniqueId(true);
        $requestConfig->setPolicyId('testpolicy');

        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<control>
    <senderid>testsenderid</senderid>
    <password>pass123!</password>
    <controlid>testcontrol</controlid>
    <uniqueid>true</uniqueid>
    <dtdversion>3.0</dtdversion>
    <policyid>testpolicy</policyid>
    <includewhitespace>false</includewhitespace>
</control>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $controlBlock = new ControlBlock($clientConfig, $requestConfig);
        $controlBlock->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlInvalidControlIdShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Request Control ID must be between 1 and 256 characters in length");

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('');

        new ControlBlock($clientConfig, $requestConfig);
    }

    public function testWriteXmlInvalidControlIdLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Request Control ID must be between 1 and 256 characters in length");

        $clientConfig = new ClientConfig();
        $clientConfig->setSenderId('testsenderid');
        $clientConfig->setSenderPassword('pass123!');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId(str_repeat('1234567890', 30)); //strlen 300

        new ControlBlock($clientConfig, $requestConfig);
    }
}
