<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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
 * @coversDefaultClass \Intacct\Functions\InventoryControl\ItemCreate
 */
class ItemCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <ITEM>
            <ITEMID>I1234</ITEMID>
            <NAME>hello world</NAME>
            <ITEMTYPE>Inventory</ITEMTYPE>
        </ITEM>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ItemCreate('unittest');
        $record->setItemId('I1234');
        $record->setItemName('hello world');
        $record->setItemType('Inventory');

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredProjectId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Item ID is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ItemCreate('unittest');
        //$record->setItemId('I1234');
        //$record->setItemName('hello world');
        //$record->setItemType('Inventory');

        $record->writeXml($xml);
    }

    public function testRequiredProjectName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Item Name is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ItemCreate('unittest');
        $record->setItemId('I1234');
        //$record->setItemName('hello world');
        //$record->setItemType('Inventory');

        $record->writeXml($xml);
    }

    public function testRequiredProjectCategory(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Item Type is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ItemCreate('unittest');
        $record->setItemId('I1234');
        $record->setItemName('hello world');
        //$record->setItemType('Inventory');

        $record->writeXml($xml);
    }
}
