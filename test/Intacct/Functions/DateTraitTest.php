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

use DateTime;

class DateTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateTraitImpl
     */
    private $traitDate;

    public function setUp()
    {
        $this->traitDate = new DateTraitImpl;
    }

    /**
     * @covers Intacct\Functions\DateTraitImpl::getAsDate
     * @covers Intacct\Functions\DateTraitImpl::getDate
     */
    public function testValidDate()
    {
        $date = date("Y/m/d");
        $currentDateTime = new DateTime($date);

        $now = $this->traitDate->getAsDate($date);

        $this->assertEquals($currentDateTime, $now);
    }

    /**
     * @covers Intacct\Functions\DateTraitImpl::getAsDate
     * @covers Intacct\Functions\DateTraitImpl::getDate
     */
    public function testValidDateString()
    {
        $stringDate = "March 11, 2015";
        $dateTime = new DateTime($stringDate);

        $asDateTime = $this->traitDate->getAsDate($stringDate);

        $this->assertEquals($dateTime, $asDateTime);
    }

    /**
     * @covers Intacct\Functions\DateTraitImpl::getAsDate
     * @covers Intacct\Functions\DateTraitImpl::getDate
     */
    public function testValidDateTime()
    {
        $stringDate = "March 11, 2015";
        $dateTime = new DateTime($stringDate);

        $asDateTime = $this->traitDate->getAsDate($dateTime);

        $this->assertEquals($dateTime, $asDateTime);
    }

    /**
     * @covers Intacct\Functions\DateTraitImpl::getDate
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Date value must be either a valid string or DateTime object
     */
    public function testInvalidType()
    {
        $invalidDate = false;

        $this->traitDate->getAsDate($invalidDate);
    }
}