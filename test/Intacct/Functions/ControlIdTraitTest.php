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


class ControlIdTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * var ControlIdTraitImpl
     */
    private $traitControlId;

    public function setUp()
    {
        $this->traitControlId = new ControlIdTraitImpl();
    }

    /**
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlId
     * @covers Intacct\Functions\ControlIdTraitImpl::getControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::getControlId
     */
    public function testValidControlId()
    {
        $control_id = "unittest";
        $this->traitControlId->setControlIdentifier($control_id);

        $this->assertEquals($control_id, $this->traitControlId->getControlIdentifier());
    }

    /**
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlId
     * @covers Intacct\Functions\ControlIdTraitImpl::getControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::getControlId
     */
    public function testNoControlId()
    {
        $this->traitControlId->setControlIdentifier();

        $this->assertNotNull($this->traitControlId->getControlIdentifier());
    }

    /**
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlId
     * @covers Intacct\Functions\ControlIdTraitImpl::getControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::getControlId
     */
    public function testMinimalLengthControlId()
    {
        $control_id = "";
        $this->traitControlId->setControlIdentifier($control_id);

        $this->assertNotNull($this->traitControlId->getControlIdentifier());
    }

    /**
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlIdentifier
     * @covers Intacct\Functions\ControlIdTraitImpl::setControlId
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage controlid must be between 1 and 256 characters in length
     */
    public function testMaximumLengthControlId()
    {
        $control_id = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567";
        $this->traitControlId->setControlIdentifier($control_id);
    }
}