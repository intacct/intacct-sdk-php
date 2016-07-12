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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class InspectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\Inspect::__construct
     * @covers Intacct\Functions\Inspect::setControlId
     * @covers Intacct\Functions\Inspect::getControlId
     * @covers Intacct\Functions\Inspect::setShowDetail
     * @covers Intacct\Functions\Inspect::getShowDetail
     * @covers Intacct\Functions\Inspect::setObjectName
     * @covers Intacct\Functions\Inspect::getObjectName
     * @covers Intacct\Functions\Inspect::getXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <inspect detail="0">
        <object>APBILL</object>
    </inspect>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $inspect = new Inspect([
            'object' => 'APBILL',
            'control_id' => 'unittest',
        ]);
        $inspect->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Inspect::__construct
     * @covers Intacct\Functions\Inspect::setControlId
     * @covers Intacct\Functions\Inspect::getControlId
     * @covers Intacct\Functions\Inspect::setShowDetail
     * @covers Intacct\Functions\Inspect::getShowDetail
     * @covers Intacct\Functions\Inspect::setObjectName
     * @covers Intacct\Functions\Inspect::getObjectName
     * @covers Intacct\Functions\Inspect::getXml
     */
    public function testParamsOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <inspect detail="1">
        <object>APBILL</object>
    </inspect>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $inspect = new Inspect([
            'object' => 'APBILL',
            'control_id' => 'unittest',
            'show_detail' => true,
        ]);
        $inspect->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Inspect::setShowDetail
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage show_detail not valid boolean type
     */
    public function testInvalidDetail()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new Inspect([
            'object' => 'APBILL',
            'control_id' => 'unittest',
            'show_detail' => "1",
        ]);
    }
}
