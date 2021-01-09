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

use Intacct\ClientConfig;
use Intacct\Functions\Company\ApiSessionCreate;
use Intacct\RequestConfig;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Xml\Request\OperationBlock
 */
class OperationBlockTest extends \PHPUnit\Framework\TestCase
{

    public function testWriteXmlSession(): void
    {
        $config = new ClientConfig();
        $config->setSessionId('fakesession..');
        
        $contentBlock = [];
        $func = new ApiSessionCreate('unittest');
        $contentBlock[] = $func;
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<operation transaction="false">
    <authentication>
        <sessionid>fakesession..</sessionid>
    </authentication>
    <content>
        <function controlid="unittest">
            <getAPISession/>
        </function>
    </content>
</operation>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $operation = new OperationBlock($config, new RequestConfig(), $contentBlock);
        $operation->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlLogin(): void
    {
        $config = new ClientConfig();
        $config->setCompanyId('testcompany');
        $config->setUserId('testuser');
        $config->setUserPassword('testpass');

        $contentBlock = [];
        $func = new ApiSessionCreate('unittest');
        $contentBlock[] = $func;
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<operation transaction="false">
    <authentication>
        <login>
            <userid>testuser</userid>
            <companyid>testcompany</companyid>
            <password>testpass</password>
        </login>
    </authentication>
    <content>
        <function controlid="unittest">
            <getAPISession/>
        </function>
    </content>
</operation>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $operation = new OperationBlock($config, new RequestConfig(), $contentBlock);
        $operation->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testWriteXmlTransaction(): void
    {
        $config = new ClientConfig();
        $config->setSessionId('fakesession..');
        $requestConfig = new RequestConfig();
        $requestConfig->setTransaction(true);

        $contentBlock = [];
        $func = new ApiSessionCreate('unittest');
        $contentBlock[] = $func;
        
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<operation transaction="true">
    <authentication>
        <sessionid>fakesession..</sessionid>
    </authentication>
    <content>
        <function controlid="unittest">
            <getAPISession/>
        </function>
    </content>
</operation>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $operation = new OperationBlock($config, $requestConfig, $contentBlock);
        $operation->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoCredentials(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Authentication credentials [Company ID, User ID, and User Password] or [Session ID] are required and cannot be blank");

        $config = new ClientConfig();
        $config->setSessionId('');
        $config->setCompanyId('');
        $config->setUserId('');
        $config->setUserPassword('');

        $contentBlock = [];
        $func = new ApiSessionCreate('unittest');
        $contentBlock[] = $func;
        new OperationBlock($config, new RequestConfig(), $contentBlock);
    }
}
