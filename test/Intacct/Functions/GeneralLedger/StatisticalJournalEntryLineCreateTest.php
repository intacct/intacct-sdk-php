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
 * @coversDefaultClass \Intacct\Functions\GeneralLedger\StatisticalJournalEntryLineCreate
 */
class StatisticalJournalEntryLineCreateTest extends \PHPUnit\Framework\TestCase
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

        $sjeEntry = new StatisticalJournalEntryLineCreate();

        $sjeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testDecreaseAmount()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO></ACCOUNTNO>
    <TR_TYPE>-1</TR_TYPE>
    <TRX_AMOUNT>100.01</TRX_AMOUNT>
</GLENTRY>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $sjeEntry = new StatisticalJournalEntryLineCreate();
        $sjeEntry->setAmount(-100.01);

        $sjeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <DOCUMENT>212</DOCUMENT>
    <ACCOUNTNO>9000</ACCOUNTNO>
    <TR_TYPE>1</TR_TYPE>
    <TRX_AMOUNT>1456.54</TRX_AMOUNT>
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

        $sjeEntry = new StatisticalJournalEntryLineCreate();
        $sjeEntry->setDocumentNumber('212');
        $sjeEntry->setStatAccountNumber('9000');
        $sjeEntry->setAmount(1456.54);
        $sjeEntry->setMemo('my memo');
        $sjeEntry->setLocationId('100');
        $sjeEntry->setDepartmentId('ADM');
        $sjeEntry->setProjectId('P100');
        $sjeEntry->setCustomerId('C100');
        $sjeEntry->setVendorId('V100');
        $sjeEntry->setEmployeeId('E100');
        $sjeEntry->setItemId('I100');
        $sjeEntry->setClassId('C200');
        $sjeEntry->setContractId('C300');
        $sjeEntry->setWarehouseId('W100');
        $sjeEntry->setCustomFields([
            'CUSTOM01' => '123',
        ]);

        $sjeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testAllocation(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO>9000</ACCOUNTNO>
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

        $sjeEntry = new StatisticalJournalEntryLineCreate();
        $sjeEntry->setStatAccountNumber('9000');
        $sjeEntry->setAmount(1456.54);
        $sjeEntry->setAllocationId('60-40');

        $sjeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testCustomAllocation(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<GLENTRY>
    <ACCOUNTNO>9000</ACCOUNTNO>
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

        $sjeEntry = new StatisticalJournalEntryLineCreate();
        $sjeEntry->setStatAccountNumber('9000');
        $sjeEntry->setAmount(1000.00);
        $sjeEntry->setAllocationId('Custom');

        $split1 = new CustomAllocationSplit();
        $split1->setAmount(600.00);

        $split2 = new CustomAllocationSplit();
        $split2->setAmount(400.00);

        $sjeEntry->setCustomAllocationSplits([
            $split1,
            $split2,
        ]);

        $sjeEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
