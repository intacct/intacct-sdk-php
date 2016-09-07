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

namespace Intacct\Functions\GlobalConsolidations;

use Intacct\FieldTypes\DateType;
use Intacct\Xml\XMLWriter;

class SpotRateReadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\GlobalConsolidations\SpotRateRead::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <getSpotRate>
        <fromCurrency>USD</fromCurrency>
        <toCurrency>CAD</toCurrency>
        <date>2016-06-30</date>
    </getSpotRate>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $rate = new SpotRateRead('unittest');
        $rate->setFromCurrency('USD');
        $rate->setToCurrency('CAD');
        $rate->setDate(new DateType('2016-06-30'));

        $rate->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
