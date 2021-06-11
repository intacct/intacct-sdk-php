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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\InvoiceLineTaxEntriesCreate
 */
class InvoiceLineTaxEntriesCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<taxentry>
    <detailid>TaxName</detailid>
</taxentry>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $taxentries = new InvoiceLineTaxEntriesCreate();
        $taxentries->setTaxId('TaxName');

        $taxentries->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<taxentry>
    <detailid>TaxName</detailid>
    <trx_tax>10</trx_tax>
</taxentry>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $taxEntries = new InvoiceLineTaxEntriesCreate();
        $taxEntries->setTaxId('TaxName');
        $taxEntries->setTaxValue(10);

        $taxEntries->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}