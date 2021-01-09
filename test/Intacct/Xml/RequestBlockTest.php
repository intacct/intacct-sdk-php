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

namespace Intacct\Xml;

use Intacct\ClientConfig;
use Intacct\RequestConfig;

/**
 * @coversDefaultClass \Intacct\Xml\RequestBlock
 */
class RequestBlockTest extends \PHPUnit\Framework\TestCase
{

    public function testWriteXml(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="iso-8859-1"?>
<request><control><senderid>testsenderid</senderid><password>pass123!</password><controlid>unittest</controlid><uniqueid>false</uniqueid><dtdversion>3.0</dtdversion><includewhitespace>false</includewhitespace></control><operation transaction="false"><authentication><sessionid>testsession..</sessionid></authentication><content></content></operation></request>
EOF;
        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');
        $config->setSessionId('testsession..');

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('unittest');

        $contentBlock = [];

        $requestHandler = new RequestBlock($config, $requestConfig, $contentBlock);

        $xml = $requestHandler->writeXml();

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
