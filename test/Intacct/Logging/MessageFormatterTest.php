<?php

/**
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

namespace Intacct\Logging;

use GuzzleHttp\Psr7\Request;
use Intacct\Content;
use Intacct\Functions\ApiSessionCreate;
use Intacct\Xml\RequestBlock;

class MessageFormatterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Logging\MessageFormatter::format
     */
    public function testPasswordRemoval()
    {
        $config = [
            'control_id' => 'unittest',
            'sender_id' => 'testsenderid',
            'sender_password' => 'pass123!',
            'company_id' => 'testcompany',
            'user_id' => 'testuser',
            'user_password' => 'P@ssW0rd!123',
        ];
        $contentBlock = new Content([
            new ApiSessionCreate('unittest'),
        ]);
        $xmlRequest = new RequestBlock($config, $contentBlock);

        $mockRequest = new Request('POST', 'https://unittest.intacct.com', [], $xmlRequest->writeXml()->flush());

        $formatter = new MessageFormatter("{req_body}");
        $message = $formatter->format($mockRequest);

        $this->assertNotContains('<password>pass123!</password>', $message);
        $this->assertNotContains('<password>P@ssW0rd!123</password>', $message);
        $this->assertContains('<password>REDACTED</password>', $message);
    }
}
