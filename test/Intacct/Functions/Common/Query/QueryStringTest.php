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

namespace Intacct\Functions\Common\Query;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query\QueryString
 */
class QueryStringTest extends \PHPUnit\Framework\TestCase
{

    public function testConstructorToString(): void
    {
        $condition = new QueryString("VENDORID = 'V1234'");

        $expected = "VENDORID = 'V1234'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testSetterToString(): void
    {
        $condition = new QueryString();
        $condition->setQuery("VENDORID = 'V1234'");

        $expected = "VENDORID = 'V1234'";

        $this->assertEquals($expected, (string)$condition);
    }
}
