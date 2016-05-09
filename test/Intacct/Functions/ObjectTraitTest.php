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

use InvalidArgumentException;

class ObjectTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectTraitImpl
     */
    private $traitObject;

    public function setUp()
    {
        $this->traitObject = new ObjectTraitImpl;
    }

    /**
     * @covers Intacct\Functions\ObjectTraitImpl::setObject
     * @covers Intacct\Functions\ObjectTraitImpl::setObjectName
     * @covers Intacct\Functions\ObjectTraitImpl::getObject
     * @covers Intacct\Functions\ObjectTraitImpl::getObjectName
     */
    public function testValidObjectName()
    {
        $name = "CLASS";
        $this->traitObject->setObject($name);

        $this->assertEquals($name, $this->traitObject->getObject());

    }

    /**
     * @covers Intacct\Functions\ObjectTraitImpl::setObject
     * @covers Intacct\Functions\ObjectTraitImpl::setObjectName
     * @covers Intacct\Functions\ObjectTraitImpl::getObject
     * @covers Intacct\Functions\ObjectTraitImpl::getObjectName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object" key not supplied in params
     */
    public function testNullObjectName()
    {
        $name = null;
        $this->traitObject->setObject($name);
    }

    /**
     * @covers Intacct\Functions\ObjectTraitImpl::setObject
     * @covers Intacct\Functions\ObjectTraitImpl::setObjectName
     * @covers Intacct\Functions\ObjectTraitImpl::getObject
     * @covers Intacct\Functions\ObjectTraitImpl::getObjectName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage object must be a string
     */
    public function testInvalidObjectName()
    {
        $name = 32;
        $this->traitObject->setObject($name);
    }
}