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

namespace Intacct\Functions\Common\Query\Comparison\Like;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query\Comparison\Like\LikeString
 */
class LikeStringTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition = new LikeString();
        $condition->setField('VENDORID');
        $condition->setValue('%123%');

        $expected = "VENDORID LIKE '%123%'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringNot(): void
    {
        $condition = new LikeString();
        $condition->setField('VENDORID');
        $condition->setValue('%123%');
        $condition->setNegate(true);

        $expected = "NOT VENDORID LIKE '%123%'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringEscapeQuotes(): void
    {
        $condition = new LikeString();
        $condition->setField('VENDORNAME');
        $condition->setValue("%ob's Pizza%");

        $expected = "VENDORNAME LIKE '%ob\'s Pizza%'";

        $this->assertEquals($expected, (string)$condition);
    }
}
