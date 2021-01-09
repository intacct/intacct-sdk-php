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
 * @coversDefaultClass \Intacct\Functions\Common\Query\Comparison\LessThanOrEqualTo\LessThanOrEqualToDate
 */
class LessThanOrEqualToDateTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition = new LessThanOrEqualToDate();
        $condition->setField('CUSTOMDATE');
        $date = new \DateTime();
        $date->setDate(2016, 12, 31);
        $condition->setValue($date);

        $expected = "CUSTOMDATE <= '12/31/2016'";

        $this->assertEquals($expected, (string)$condition);
    }

    public function testToStringNot(): void
    {
        $condition = new LessThanOrEqualToDate();
        $condition->setField('CUSTOMDATE');
        $date = new \DateTime();
        $date->setDate(2016, 12, 31);
        $condition->setValue($date);
        $condition->setNegate(true);

        $expected = "NOT CUSTOMDATE <= '12/31/2016'";

        $this->assertEquals($expected, (string)$condition);
    }
}
