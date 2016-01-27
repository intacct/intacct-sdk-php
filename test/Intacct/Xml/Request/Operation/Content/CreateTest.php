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

use XMLWriter;

class CreateTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Create::__construct
     * @covers Intacct\Xml\Request\Operation\Content\Create::getXml
     */
    public function testGetXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="create">
    <create>
        <CLASS>
            <CLASSID>UT01</CLASSID>
            <NAME>Unit Test 01</NAME>
        </CLASS>
    </create>
</function>
EOF;

        $records = [
            new Record([
                'object' => 'CLASS',
                'fields' => [
                    'CLASSID' => 'UT01',
                    'NAME' => 'Unit Test 01',
                ],
            ]),
        ];

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $create = new Create([
            'records' => $records,
        ]);
        $create->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Create::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage records count cannot exceed 100
     */
    public function testTooManyRecords()
    {
        $records = [];
        for ($i = 1; $i <= 101; $i++) {
            $records[] = new Record([
                'object' => 'CLASS',
                'fields' => [
                    'CLASSID' => 'UT' . $i,
                    'NAME' => 'Unit Test ' . $i,
                ],
            ]);
        }

        $create = new Create([
            'records' => $records,
        ]);
    }

    /**
     * @covers Intacct\Xml\Request\Operation\Content\Create::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage records count must be greater than zero
     */
    public function testNoRecords()
    {
        $records = [];

        $create = new Create([
            'records' => $records,
        ]);
    }

}
