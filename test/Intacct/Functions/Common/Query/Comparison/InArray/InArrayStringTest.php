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

namespace Intacct\Functions\Common\Query\Comparison\InArray;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query\Comparison\InArray\InArrayString
 */
class InArrayStringTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition = new InArrayString();
        $condition->setField('RECORDNO');
        $condition->setValue([ 'a', 'b', 'c' ]);

        $expected = "RECORDNO IN ('a','b','c')";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringNot(): void
    {
        $condition = new InArrayString();
        $condition->setField('RECORDNO');
        $condition->setValue([ 'a', 'b', 'c' ]);
        $condition->setNegate(true);

        $expected = "RECORDNO NOT IN ('a','b','c')";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringEscapeQuotes(): void
    {
        $condition = new InArrayString();
        $condition->setField('RECORDNO');
        $condition->setValue([ "bob's pizza", "bill's pizza", "sally's pizza" ]);
        $condition->setNegate(true);

        $expected = "RECORDNO NOT IN ('bob\'s pizza','bill\'s pizza','sally\'s pizza')";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testCountOneToString(): void
    {
        $condition = new InArrayString();
        $condition->setField('RECORDNO');
        $condition->setValue([ 'a' ]);

        $expected = "RECORDNO IN ('a')";

        $this->assertEquals($expected, (string)$condition);
    }
}
