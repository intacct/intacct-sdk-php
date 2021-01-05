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
 * @coversDefaultClass \Intacct\Functions\Common\Query\Logical\OrCondition
 */
class OrConditionTest extends \PHPUnit\Framework\TestCase
{

    public function testToString(): void
    {
        $condition1 = new EqualToString();
        $condition1->setField('VENDORID');
        $condition1->setValue('V1234');

        $condition2 = new EqualToString();
        $condition2->setField('VENDORID');
        $condition2->setValue('V5678');

        $or = new OrCondition();
        $or->setConditions([
            $condition1,
            $condition2,
        ]);

        $expected = "(VENDORID = 'V1234' OR VENDORID = 'V5678')";

        $this->assertEquals($expected, (string)$or);
    }

    public function testToStringNot(): void
    {
        $condition1 = new EqualToString();
        $condition1->setField('VENDORID');
        $condition1->setValue('V1234');

        $condition2 = new EqualToString();
        $condition2->setField('VENDORID');
        $condition2->setValue('V5678');

        $or = new OrCondition();
        $or->setConditions([
            $condition1,
            $condition2,
        ]);
        $or->setNegate(true);

        $expected = "NOT (VENDORID = 'V1234' OR VENDORID = 'V5678')";

        $this->assertEquals($expected, (string)$or);
    }

    public function testNestConditionsToString(): void
    {
        $condition1 = new EqualToString();
        $condition1->setField('VENDORTYPE');
        $condition1->setValue('Software');

        $condition2 = new EqualToString();
        $condition2->setField('VENDORID');
        $condition2->setValue('V1234');

        $condition3 = new EqualToString();
        $condition3->setField('VENDORID');
        $condition3->setValue('V5678');

        $nested = new OrCondition();
        $nested->setConditions([
            $condition2,
            $condition3,
        ]);

        $or = new OrCondition();
        $or->setConditions([
            $condition1,
            $nested,
        ]);

        $expected = "(VENDORTYPE = 'Software' OR (VENDORID = 'V1234' OR VENDORID = 'V5678'))";

        $this->assertEquals($expected, (string)$or);
    }
}
