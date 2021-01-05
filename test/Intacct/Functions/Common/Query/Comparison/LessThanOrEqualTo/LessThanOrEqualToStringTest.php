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

namespace Intacct\Functions\Common\Query\Comparison\LessThanOrEqualTo;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query\Comparison\LessThanOrEqualTo\LessThanOrEqualToString
 */
class LessThanOrEqualToStringTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition = new LessThanOrEqualToString();
        $condition->setField('VENDORID');
        $condition->setValue('V1234');

        $expected = "VENDORID <= 'V1234'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringNot(): void
    {
        $condition = new LessThanOrEqualToString();
        $condition->setField('VENDORID');
        $condition->setValue('V1234');
        $condition->setNegate(true);

        $expected = "NOT VENDORID <= 'V1234'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringEscapeQuotes(): void
    {
        $condition = new LessThanOrEqualToString();
        $condition->setField('VENDORNAME');
        $condition->setValue("Bob's Pizza, Inc.");

        $expected = "VENDORNAME <= 'Bob\'s Pizza, Inc.'";

        $this->assertEquals($expected, (string)$condition);
    }
}
