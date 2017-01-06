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

namespace Intacct\Functions\Common;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Delete
 */
class DeleteTest extends \PHPUnit_Framework_TestCase
{

    public function testWriteXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <delete>
        <object>CLASS</object>
        <keys>5,6</keys>
    </delete>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $delete = new Delete('unittest');
        $delete->setObjectName('CLASS');
        $delete->setKeys([
            '5',
            '6',
        ]);

        $delete->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Keys count cannot exceed 100
     */
    public function testTooManyKeys()
    {
        $keys = [];
        for ($i = 1; $i <= 101; $i++) {
            $keys[] = $i;
        }

        $delete = new Delete('unittest');
        $delete->setObjectName('CLASS');
        $delete->setKeys($keys);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Keys count must be greater than zero
     */
    public function testNoKeys()
    {
        $keys = [];

        $delete = new Delete('unittest');
        $delete->setObjectName('CLASS');
        $delete->setKeys($keys);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Using delete on object "TIMESHEETENTRY" is not allowed
     */
    public function testNotAllowedObject()
    {
        $delete = new Delete('unittest');
        $delete->setObjectName('TIMESHEETENTRY');
    }
}
