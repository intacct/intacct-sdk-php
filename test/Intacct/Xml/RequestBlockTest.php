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

namespace Intacct\Tests\Xml;

use Intacct\Xml\Request\Operation\ContentBlock;
use Intacct\Xml\RequestBlock;

class RequestBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Xml\RequestBlock::__construct
     * @covers Intacct\Xml\RequestBlock::getXml
     * @covers Intacct\Xml\RequestBlock::getVerifySSL
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="iso-8859-1"?>
<request><control><senderid>testsenderid</senderid><password>pass123!</password><controlid>requestControlId</controlid><uniqueid>false</uniqueid><dtdversion>3.0</dtdversion><policyid/><includewhitespace>false</includewhitespace></control><operation transaction="false"><authentication><sessionid>testsession..</sessionid></authentication><content></content></operation></request>
EOF;

        $config = [
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'session_id' => 'testsession..',
        ];

        $contentBlock = new ContentBlock();

        $requestHandler = new RequestBlock($config, $contentBlock);

        $xml = $requestHandler->getXml();

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
