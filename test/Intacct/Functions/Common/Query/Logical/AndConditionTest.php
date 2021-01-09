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

namespace Intacct\Functions\Common\Query\Logical;

use Intacct\Functions\Common\Query\Comparison\EqualTo\EqualToString;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Query\Logical\AndCondition
 */
class AndConditionTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition1 = new EqualToString();
        $condition1->setField('VENDORID');
        $condition1->setValue('V1234');

        $condition2 = new EqualToString();
        $condition2->setField('STATUS');
        $condition2->setValue('T');

        $and = new AndCondition();
        $and->setConditions([
            $condition1,
            $condition2,
        ]);

        $expected = "(VENDORID = 'V1234' AND STATUS = 'T')";

        $this->assertEquals($expected, (string)$and);
    }

    public function testToStringNot(): void
    {
        $condition1 = new EqualToString();
        $condition1->setField('VENDORID');
        $condition1->setValue('V1234');

        $condition2 = new EqualToString();
        $condition2->setField('STATUS');
        $condition2->setValue('T');

        $and = new AndCondition();
        $and->setConditions([
            $condition1,
            $condition2,
        ]);
        $and->setNegate(true);

        $expected = "NOT (VENDORID = 'V1234' AND STATUS = 'T')";

        $this->assertEquals($expected, (string)$and);
    }
}
