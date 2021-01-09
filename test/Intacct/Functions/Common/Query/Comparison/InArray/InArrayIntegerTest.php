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
 * @coversDefaultClass \Intacct\Functions\Common\Query\Comparison\InArray\InArrayInteger
 */
class InArrayIntegerTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition = new InArrayInteger();
        $condition->setField('RECORDNO');
        $condition->setValue([ 1234, 5678, 9012 ]);

        $expected = "RECORDNO IN (1234,5678,9012)";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringNot(): void
    {
        $condition = new InArrayInteger();
        $condition->setField('RECORDNO');
        $condition->setValue([ 1234, 5678, 9012 ]);
        $condition->setNegate(true);

        $expected = "RECORDNO NOT IN (1234,5678,9012)";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testCountOneToString(): void
    {
        $condition = new InArrayInteger();
        $condition->setField('RECORDNO');
        $condition->setValue([ 1234 ]);

        $expected = "RECORDNO IN (1234)";

        $this->assertEquals($expected, (string)$condition);
    }
}
