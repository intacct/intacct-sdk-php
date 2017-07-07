<?php
/**
 * Copyright 2017 Intacct Corporation.
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

namespace Intacct;

/**
 * @coversDefaultClass \Intacct\RequestConfig
 */
class RequestConfigTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Encoding "invalid" is not supported by the system
     */
    public function testInvalidEncoding()
    {
        $config = new RequestConfig();
        $config->setEncoding('invalid');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Max Retries must be zero or greater
     */
    public function testNegativeRetries()
    {
        $config = new RequestConfig();
        $config->setMaxRetries(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Max Timeout must be zero or greater
     */
    public function testNegativeTimeout()
    {
        $config = new RequestConfig();
        $config->setMaxTimeout(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No Retry Server Error Code is not valid int type
     */
    public function testNoRetryServerErrorCodeNotInt()
    {
        $config = new RequestConfig();
        $config->setNoRetryServerErrorCodes([
            '524',
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No Retry Server Error Codes must be between 500-599
     */
    public function testNoRetryServerErrorCodeNot500()
    {
        $config = new RequestConfig();
        $config->setNoRetryServerErrorCodes([
            400,
        ]);
    }
}
