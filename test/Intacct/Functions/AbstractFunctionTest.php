<?php

/**
 * Copyright 2016 Intacct Corporation.
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

namespace Intacct\Functions;

use InvalidArgumentException;

class AbstractFunctionTest extends \PHPUnit_Framework_TestCase
{

    /** @var AbstractFunction */
    protected $object;

    public function setUp()
    {
        $this->object = $this->getMockForAbstractClass(AbstractFunction::class);
    }

    /**
     * @covers Intacct\Functions\AbstractFunction::setControlId
     * @covers Intacct\Functions\AbstractFunction::getControlId
     */
    public function testValidControlId()
    {
        $controlId = "unittest";
        $this->object->setControlId($controlId);

        $this->assertEquals($controlId, $this->object->getControlId());
    }

    /**
     * @covers Intacct\Functions\AbstractFunction::setControlId
     * @covers Intacct\Functions\AbstractFunction::getControlId
     */
    public function testNoControlId()
    {
        $this->object->setControlId();

        $this->assertNotNull($this->object->getControlId());
    }

    /**
     * @covers Intacct\Functions\AbstractFunction::setControlId
     * @covers Intacct\Functions\AbstractFunction::getControlId
     */
    public function testMinimalLengthControlId()
    {
        $controlId = "";
        $this->object->setControlId($controlId);

        $this->assertNotNull($this->object->getControlId());
    }

    /**
     * @covers Intacct\Functions\AbstractFunction::setControlId
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage controlid must be between 1 and 256 characters in length
     */
    public function testMaximumLengthControlId()
    {
        $controlId = "12345678901234567890123456789012345678901234567890"
            . "123456789012345678901234567890123456789012345678901234567890"
            . "123456789012345678901234567890123456789012345678901234567890"
            . "123456789012345678901234567890123456789012345678901234567890"
            . "123456789012345678901234567";
        $this->object->setControlId($controlId);
    }
}
