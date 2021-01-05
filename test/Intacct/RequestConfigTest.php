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

namespace Intacct;

/**
 * @coversDefaultClass \Intacct\RequestConfig
 */
class RequestConfigTest extends \PHPUnit\Framework\TestCase
{

    public function testInvalidEncoding(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Encoding \"invalid\" is not supported by the system");

        $config = new RequestConfig();
        $config->setEncoding('invalid');
    }

    public function testNegativeRetries(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Max Retries must be zero or greater");

        $config = new RequestConfig();
        $config->setMaxRetries(-1);
    }

    public function testNegativeTimeout(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Max Timeout must be zero or greater");

        $config = new RequestConfig();
        $config->setMaxTimeout(-1);
    }

    public function testNoRetryServerErrorCodeNotInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No Retry Server Error Code is not valid int type");

        $config = new RequestConfig();
        $config->setNoRetryServerErrorCodes([
            '524',
        ]);
    }

    public function testNoRetryServerErrorCodeNot500(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No Retry Server Error Codes must be between 500-599");

        $config = new RequestConfig();
        $config->setNoRetryServerErrorCodes([
            400,
        ]);
    }
}
