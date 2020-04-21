<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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

namespace Intacct\Tests\Functions\Common\Order;

use Intacct\Functions\Common\QueryOrderBy\OrderBuilder;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use TypeError;

/**
 * @coversDefaultClass \Intacct\Functions\Common\QueryOrderBy\OrderBuilder
 */
class OrderBuilderTest extends \PHPUnit\Framework\TestCase
{

    public function testAscending()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<order>
    <field>RECORDNO</field>
    <ascending/>
</order>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orders = ( new OrderBuilder() )->ascending('RECORDNO')
                                        ->getOrders();

        foreach ( $orders as $order ) {
            $order->writeXML($xml);
        }

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException TypeError
     */
    public function testNullAscending()
    {
        ( new OrderBuilder() )->ascending(null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage  Field name for field cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyAscending()
    {
        ( new OrderBuilder() )->ascending('');
    }

    public function testDescending()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<order>
    <field>RECORDNO</field>
    <descending/>
</order>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $orders = ( new OrderBuilder() )->descending('RECORDNO')
                                        ->getOrders();

        foreach ( $orders as $order ) {
            $order->writeXML($xml);
        }

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException TypeError
     */
    public function testNullDescending()
    {
        ( new OrderBuilder() )->descending(null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage  Field name for field cannot be empty or null. Provide a field for the builder.
     */
    public function testEmptyDescending()
    {
        ( new OrderBuilder() )->descending('');
    }

}