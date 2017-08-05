<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

namespace Intacct\Functions\InventoryControl;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\InventoryControl\WarehouseCreate
 */
class WarehouseCreateTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <WAREHOUSE>
            <WAREHOUSEID>W1234</WAREHOUSEID>
            <NAME>hello world</NAME>
            <LOC>
                <LOCATIONID>L1234</LOCATIONID>
            </LOC>
        </WAREHOUSE>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new WarehouseCreate('unittest');
        $record->setWarehouseId('W1234');
        $record->setWarehouseName('hello world');
        $record->setLocationId('L1234');

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Warehouse ID is required for create
     */
    public function testRequiredWarehouseId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new WarehouseCreate('unittest');
        //$record->setWarehouseId('W1234');
        $record->setWarehouseName('hello world');
        $record->setLocationId('L1234');

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Warehouse Name is required for create
     */
    public function testRequiredWarehouseName()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new WarehouseCreate('unittest');
        $record->setWarehouseId('W1234');
        //$record->setWarehouseName('hello world');
        $record->setLocationId('L1234');

        $record->writeXml($xml);
    }

    /**
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

        $record = new WarehouseCreate('unittest');
        $record->setWarehouseId('W1234');
        $record->setWarehouseName('hello world');
        //$record->setLocationId('L1234');

        $record->writeXml($xml);
    }
}
