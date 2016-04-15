<?php

/*
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

namespace Intacct\Xml\Request\Operation\Content;

use InvalidArgumentException;

class RecordTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Record::__construct
     * @covers Intacct\Xml\Request\Operation\Content\Record::getObjectName
     */
    public function testConstructSuccess()
    {
        $record = new Record([
            'object' => 'CLASS',
            'fields' => [
                'CLASSID' => 'UT01',
                'NAME' => 'Unit Test 01',
            ],
        ]);
        $this->assertEquals('CLASS', $record->getObjectName());
        $this->assertCount(2, $record);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Record::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object" key not supplied in params
     */
    public function testConstructFailureNoObject()
    {
        new Record([
            'fields' => [
                'CLASSID' => 'UT01',
                'NAME' => 'Unit Test 01',
            ],
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Record::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage fields count must be greater than zero
     */
    public function testConstructFailureNoFields()
    {
        new Record([
            'object' => 'CLASS',
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Record::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage object name "123INVALID" is not a valid name for an XML element
     */
    public function testConstructFailureInvalidObjectName()
    {
        new Record([
            'object' => '123INVALID',
            'fields' => [
                'CLASSID' => 'UT01',
                'NAME' => 'Unit Test 01',
            ],
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Record::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage field name "456INVALID" is not a valid name for an XML element
     */
    public function testConstructFailureInvalidFieldName()
    {
        new Record([
            'object' => 'CLASS',
            'fields' => [
                'CLASSID' => 'UT01',
                'NAME' => 'Unit Test 01',
                '456INVALID' => 'unit test',
            ],
        ]);
    }

}
