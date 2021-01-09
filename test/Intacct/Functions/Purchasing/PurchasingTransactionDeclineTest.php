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

namespace Intacct\Functions\Purchasing;

use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\Purchasing\PurchasingTransactionCreate
 */
class PurchasingTransactionDeclineTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {

        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <decline>
        <PODOCUMENT>
            <DOCID>Purchase Order-PO0213</DOCID>
            <COMMENT>Need to wait on this</COMMENT>
        </PODOCUMENT>
    </decline>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $transaction = new PurchasingTransactionDecline('unittest');
        $transaction->setExternalId('Purchase Order-PO0213');
        $transaction->setComment('Need to wait on this');

        $transaction->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
