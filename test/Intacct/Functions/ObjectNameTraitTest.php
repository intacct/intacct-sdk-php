<?php
/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Functions;

use Intacct\Functions\Traits\ObjectNameTrait;
use InvalidArgumentException;

class ObjectNameTraitTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    public function setUp()
    {
        $this->object = $this->getMockForTrait(ObjectNameTrait::class);
    }

    public function testValidObjectName()
    {
        $name = "CLASS";
        $this->object->setObjectName($name);

        $this->assertEquals($name, $this->object->getObjectName());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object" key not supplied in params
     */
    public function testNullObjectName()
    {
        $name = null;
        $this->object->setObjectName($name);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage object must be a string
     */
    public function testInvalidObjectName()
    {
        $name = 32;
        $this->object->setObjectName($name);
    }
}
