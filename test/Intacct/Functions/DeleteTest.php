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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class DeleteTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Delete::__construct
     * @covers Intacct\Functions\Delete::setKeys
     * @covers Intacct\Functions\Delete::getKeys
     * @covers Intacct\Functions\Delete::getXml
     */
    public function testGetXml()
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

        $delete = new Delete([
            'object' => 'CLASS',
            'keys' => [
                '5',
                '6',
            ],
            'control_id' => 'unittest'
        ]);
        $delete->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Delete::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object" key not supplied in params
     */
    public function testNoObject()
    {
        new Delete([
            'keys' => [
                '5'
            ],
        ]);
    }

    /**
     * @covers Intacct\Functions\Delete::setKeys
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage keys count cannot exceed 100
     */
    public function testTooManyKeys()
    {
        $keys = [];
        for ($i = 1; $i <= 101; $i++) {
            $keys[] = $i;
        }

        new Delete([
            'object' => 'CLASS',
            'keys' => $keys,
        ]);
    }

    /**
     * @covers Intacct\Functions\Delete::setKeys
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage keys count must be greater than zero
     */
    public function testNoKeys()
    {
        $keys = [];

        new Delete([
            'object' => 'CLASS',
            'keys' => $keys,
        ]);
    }

    /**
     * @covers Intacct\Functions\Delete::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage using delete on object "TIMESHEETENTRY" is not allowed
     */
    public function testNotAllowedObject()
    {
        new Delete([
            'object' => 'TIMESHEETENTRY',
            'keys' => [
                '5',
                '6',
            ],
        ]);
    }

}
