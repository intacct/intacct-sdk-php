<?php
/**
 *
 * *
 *  * Copyright 2016 Intacct Corporation.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  * use this file except in compliance with the License. You may obtain a copy
 *  * of the License at
 *  *
 *  * http://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * or in the "LICENSE" file accompanying this file. This file is distributed on
 *  * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 *  * express or implied. See the License for the specific language governing
 *  * permissions and limitations under the License.
 *
 *
 */

namespace Intacct\Functions\OrderEntry;

use Intacct\Xml\XMLWriter;

class CreateItemDetailTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::__construct
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::setItemExpiration
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::getXml
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::getSerialOrLotNumberXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<itemdetail>
    <quantity>5523</quantity>
    <lotno>223</lotno>
    <itemexpiration>
        <year>2017</year>
        <month>12</month>
        <day>31</day>
    </itemexpiration>
</itemdetail>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $itemDetail = new CreateItemDetail([
            'quantity' => 5523,
            'lot_number' => 223,
            'item_expiration' => '2017-12-31',
        ]);

        $itemDetail->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::__construct
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::setItemExpiration
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::getXml
     * @covers Intacct\Functions\OrderEntry\CreateItemDetail::getSerialOrLotNumberXml
     *
     */
    public function testParamsOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<itemdetail>
    <quantity>15325</quantity>
    <serialno>S2355235</serialno>
    <aisle>55</aisle>
    <row>1</row>
    <bin>12</bin>
</itemdetail>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $itemDetail = new CreateItemDetail([
            'quantity' => 15325,
            'serial_number' => 'S2355235',
            'aisle' => 55,
            'row' => 1,
            'bin' => '12',
        ]);

        $itemDetail->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}