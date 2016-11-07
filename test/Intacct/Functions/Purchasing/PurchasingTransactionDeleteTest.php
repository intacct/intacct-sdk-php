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

namespace Intacct\Functions\Purchasing;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class PurchasingTransactionDeleteTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Purchasing\PurchasingTransactionDelete::writeXml
     */
    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <delete_potransaction key="Vendor Invoice-VI4321" />
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $classObj = new PurchasingTransactionDelete('unittest');
        $classObj->setRecordNo('Vendor Invoice-VI4321');

        $classObj->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Purchasing\PurchasingTransactionDelete::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Document ID is required for delete
     */
    public function testRequiredId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new PurchasingTransactionDelete('unittest');

        $obj->writeXml($xml);
    }
}
