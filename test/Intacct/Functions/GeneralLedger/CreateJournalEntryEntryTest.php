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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;

class CreateJournalEntryEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO></ACCOUNTNO>
    <TRTYPE>1</TRTYPE>
    <AMOUNT></AMOUNT>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new CreateJournalEntryEntry([
            // null
        ]);
        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::writeXml
     */
    public function testCreditAmount()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO></ACCOUNTNO>
    <TRTYPE>-1</TRTYPE>
    <AMOUNT>400.23</AMOUNT>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new CreateJournalEntryEntry([
            'transaction_amount' => -400.23
        ]);
        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <DOCUMENT>212</DOCUMENT>
    <ACCOUNTNO>1010</ACCOUNTNO>
    <TRTYPE>1</TRTYPE>
    <AMOUNT>1456.54</AMOUNT>
    <CURRENCY>USD</CURRENCY>
    <EXCH_RATE_DATE>06/30/2016</EXCH_RATE_DATE>
    <EXCH_RATE_TYPE_ID>Intacct Daily Rate</EXCH_RATE_TYPE_ID>
    <LOCATION>100</LOCATION>
    <DEPARTMENT>ADM</DEPARTMENT>
    <PROJECTID>P100</PROJECTID>
    <CUSTOMERID>C100</CUSTOMERID>
    <VENDORID>V100</VENDORID>
    <EMPLOYEEID>E100</EMPLOYEEID>
    <ITEMID>I100</ITEMID>
    <CLASSID>C200</CLASSID>
    <CONTRACTID>C300</CONTRACTID>
    <WAREHOUSEID>W100</WAREHOUSEID>
    <DESCRIPTION>my memo</DESCRIPTION>
    <CUSTOM01>123</CUSTOM01>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new CreateJournalEntryEntry([
            'document_number' => '212',
            'gl_account_no' => '1010',
            'transaction_amount' => 1456.54,
            'transaction_currency' => 'USD',
            'exchange_rate_date' => new Date('2016-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'memo' => 'my memo',
            'location_id' => '100',
            'department_id' => 'ADM',
            'project_id' => 'P100',
            'customer_id' => 'C100',
            'vendor_id' => 'V100',
            'employee_id' => 'E100',
            'item_id' => 'I100',
            'class_id' => 'C200',
            'contract_id' => 'C300',
            'warehouse_id' => 'W100',
            'custom_fields' => [
                'CUSTOM01' => '123'
            ],
        ]);
        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::writeXml
     */
    public function testAllocation()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO>1010</ACCOUNTNO>
    <TRTYPE>1</TRTYPE>
    <AMOUNT>1456.54</AMOUNT>
    <ALLOCATION>60-40</ALLOCATION>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new CreateJournalEntryEntry([
            'gl_account_no' => '1010',
            'transaction_amount' => 1456.54,
            'allocation_id' => '60-40',
        ]);
        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntryEntry::writeXml
     */
    public function testCustomAllocation()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO>1010</ACCOUNTNO>
    <TRTYPE>1</TRTYPE>
    <AMOUNT>1000</AMOUNT>
    <ALLOCATION>Custom</ALLOCATION>
    <SPLIT>
        <AMOUNT>600</AMOUNT>
    </SPLIT>
    <SPLIT>
        <AMOUNT>400</AMOUNT>
    </SPLIT>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new CreateJournalEntryEntry([
            'gl_account_no' => '1010',
            'transaction_amount' => 1000.00,
            'allocation_id' => 'Custom',
            'custom_allocation_splits' => [
                [
                    'amount' => 600.00,
                ],
                [
                    'amount' => 400.00,
                ],
            ],
        ]);
        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
