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

namespace Intacct\Functions\Common\Query\Comparison\LessThan;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query\Comparison\LessThan\LessThanDateTime
 */
class LessThanDateTimeTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition = new LessThanDateTime();
        $condition->setField('CUSTOMDATE');
        $dateTime = new \DateTime();
        $dateTime->setDate(2016, 12, 31);
        $dateTime->setTime(23, 59, 59);
        $condition->setValue($dateTime);

        $expected = "CUSTOMDATE < '12/31/2016 23:59:59'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringNot(): void
    {
        $condition = new LessThanDateTime();
        $condition->setField('CUSTOMDATE');
        $dateTime = new \DateTime();
        $dateTime->setDate(2016, 12, 31);
        $dateTime->setTime(23, 59, 59);
        $condition->setValue($dateTime);
        $condition->setNegate(true);

        $expected = "NOT CUSTOMDATE < '12/31/2016 23:59:59'";

        $this->assertEquals($expected, (string)$condition);
    }
}
