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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Xml\XMLWriter;

/**
 * @coversDefaultClass \Intacct\Functions\GeneralLedger\JournalEntryLineCreate
 */
class JournalEntryLineCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO></ACCOUNTNO>
    <TR_TYPE>1</TR_TYPE>
    <TRX_AMOUNT></TRX_AMOUNT>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new JournalEntryLineCreate();

        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testCreditAmount()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO></ACCOUNTNO>
    <TR_TYPE>-1</TR_TYPE>
    <TRX_AMOUNT>400.23</TRX_AMOUNT>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new JournalEntryLineCreate();
        $jeEntry->setTransactionAmount(-400.23);

        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <DOCUMENT>212</DOCUMENT>
    <ACCOUNTNO>1010</ACCOUNTNO>
    <TR_TYPE>1</TR_TYPE>
    <TRX_AMOUNT>1456.54</TRX_AMOUNT>
    <CURRENCY>USD</CURRENCY>
    <EXCH_RATE_DATE>06/30/2016</EXCH_RATE_DATE>
    <EXCH_RATE_TYPE_ID>Intacct Daily Rate</EXCH_RATE_TYPE_ID>
    <LOCATION>100</LOCATION>
    <DEPARTMENT>ADM</DEPARTMENT>
    <PROJECTID>P100</PROJECTID>
    <TASKID>T123</TASKID>
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

        $jeEntry = new JournalEntryLineCreate();
        $jeEntry->setDocumentNumber('212');
        $jeEntry->setGlAccountNumber('1010');
        $jeEntry->setTransactionAmount(1456.54);
        $jeEntry->setTransactionCurrency('USD');
        $jeEntry->setExchangeRateDate(new \DateTime('2016-06-30'));
        $jeEntry->setExchangeRateType('Intacct Daily Rate');
        $jeEntry->setMemo('my memo');
        $jeEntry->setLocationId('100');
        $jeEntry->setDepartmentId('ADM');
        $jeEntry->setProjectId('P100');
        $jeEntry->setTaskId('T123');
        $jeEntry->setCustomerId('C100');
        $jeEntry->setVendorId('V100');
        $jeEntry->setEmployeeId('E100');
        $jeEntry->setItemId('I100');
        $jeEntry->setClassId('C200');
        $jeEntry->setContractId('C300');
        $jeEntry->setWarehouseId('W100');
        $jeEntry->setCustomFields([
            'CUSTOM01' => '123',
        ]);

        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAllocation(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO>1010</ACCOUNTNO>
    <TR_TYPE>1</TR_TYPE>
    <TRX_AMOUNT>1456.54</TRX_AMOUNT>
    <ALLOCATION>60-40</ALLOCATION>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $jeEntry = new JournalEntryLineCreate();
        $jeEntry->setGlAccountNumber('1010');
        $jeEntry->setTransactionAmount(1456.54);
        $jeEntry->setAllocationId('60-40');

        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testCustomAllocation(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO>1010</ACCOUNTNO>
    <TR_TYPE>1</TR_TYPE>
    <TRX_AMOUNT>1000</TRX_AMOUNT>
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

        $jeEntry = new JournalEntryLineCreate();
        $jeEntry->setGlAccountNumber('1010');
        $jeEntry->setTransactionAmount(1000.00);
        $jeEntry->setAllocationId('Custom');

        $split1 = new CustomAllocationSplit();
        $split1->setAmount(600.00);

        $split2 = new CustomAllocationSplit();
        $split2->setAmount(400.00);

        $jeEntry->setCustomAllocationSplits([
            $split1,
            $split2,
        ]);

        $jeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
