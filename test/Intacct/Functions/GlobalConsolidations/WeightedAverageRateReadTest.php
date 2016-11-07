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

class WeightedAverageRateReadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\GlobalConsolidations\WeightedAverageRateRead::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <getWARate>
        <fromCurrency>USD</fromCurrency>
        <toCurrency>CAD</toCurrency>
        <fromDate>2016-06-01</fromDate>
        <toDate>2016-06-30</toDate>
    </getWARate>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $rate = new WeightedAverageRateRead('unittest');
        $rate->setFromCurrency('USD');
        $rate->setToCurrency('CAD');
        $rate->setFromDate(new DateType('2016-06-01'));
        $rate->setToDate(new DateType('2016-06-30'));

        $rate->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
