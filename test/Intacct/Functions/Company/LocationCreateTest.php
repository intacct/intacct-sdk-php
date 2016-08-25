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

namespace Intacct\Functions\Company;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class LocationCreateTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Company\LocationCreate::writeXml
     */
    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <LOCATION>
            <LOCATIONID>L1234</LOCATIONID>
            <NAME>hello world</NAME>
        </LOCATION>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $location = new LocationCreate('unittest');
        $location->setLocationId('L1234');
        $location->setLocationName('hello world');

        $location->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Company\LocationCreate::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Location ID is required for create
     */
    public function testRequiredLocationId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $location = new LocationCreate('unittest');
        //$location->setLocationId('L1234');
        $location->setLocationName('hello world');

        $location->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\Company\LocationCreate::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Location Name is required for create
     */
    public function testRequiredDepartmentName()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $location = new LocationCreate('unittest');
        $location->setLocationId('L1234');
        //$location->setLocationName('hello world');

        $location->writeXml($xml);
    }
}
