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

namespace Intacct\Functions\DDS;

use Intacct\Xml\XMLWriter;

class GetObjectsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\DDS\GetObjects::__construct
     * @covers Intacct\Functions\DDS\GetObjects::getXML
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <getDdsObjects/>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $objects = new GetObjects([
            'control_id' => 'unittest',
        ]);

        $objects->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}