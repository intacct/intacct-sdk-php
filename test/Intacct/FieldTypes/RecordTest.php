<?php

/**
 * Copyright 2017 Intacct Corporation.
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

namespace Intacct\FieldTypes;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\FieldTypes\Record
 */
class RecordTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $record = new Record();
        $record->setObjectName('CLASS');
        $record->setFields([
            'CLASSID' => 'UT01',
            'NAME' => 'Unit Test 01',
        ]);

        $this->assertEquals('CLASS', $record->getObjectName());
        $this->assertCount(2, $record->getFields());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object Name is required for the record
     */
    public function tesNoObject()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new Record();
        //$record->setObjectName('CLASS');
        $record->setFields([
            'CLASSID' => 'UT01',
            'NAME' => 'Unit Test 01',
        ]);

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "123INVALID" is not a valid name for an XML element
     */
    public function testInvalidObjectName()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new Record();
        $record->setObjectName('123INVALID');

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "456INVALID" is not a valid name for an XML element
     */
    public function testConstructFailureInvalidFieldName()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new Record();
        $record->setObjectName('CLASS');
        $record->setFields([
            'CLASSID' => 'UT01',
            'NAME' => 'Unit Test 01',
            '456INVALID' => 'unit test',
        ]);

        $record->writeXml($xml);
    }
}
