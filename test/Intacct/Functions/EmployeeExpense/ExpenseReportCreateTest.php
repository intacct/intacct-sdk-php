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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\EmployeeExpense\ExpenseReportCreate
 */
class ExpenseReportCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_expensereport>
        <employeeid>E0001</employeeid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <expenses>
            <expense>
                <glaccountno/>
            </expense>
        </expenses>
    </create_expensereport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $expense = new ExpenseReportCreate('unittest');
        $expense->setEmployeeId('E0001');
        $expense->setTransactionDate(new \DateTime('2015-06-30'));

        $line1 = new ExpenseReportLineCreate();

        $expense->setLines([
            $line1,
        ]);

        $expense->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_expensereport>
        <employeeid>E0001</employeeid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <dateposted>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </dateposted>
        <batchkey>123</batchkey>
        <expensereportno>ER001</expensereportno>
        <state>Submitted</state>
        <description>For hotel</description>
        <memo>Memo</memo>
        <externalid>122</externalid>
        <basecurr>USD</basecurr>
        <currency>USD</currency>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <supdocid>AT122</supdocid>
        <expenses>
            <expense>
                <glaccountno/>
            </expense>
        </expenses>
    </create_expensereport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $expense = new ExpenseReportCreate('unittest');
        $expense->setEmployeeId('E0001');
        $expense->setTransactionDate(new \DateTime('2015-06-30'));
        $expense->setGlPostingDate(new \DateTime('2015-06-30'));
        $expense->setSummaryRecordNo('123');
        $expense->setExpenseReportNumber('ER001');
        $expense->setAction('Submitted');
        $expense->setReasonForExpense('For hotel');
        $expense->setMemo('Memo');
        $expense->setExternalId('122');
        $expense->setBaseCurrency('USD');
        $expense->setReimbursementCurrency('USD');
        $expense->setAttachmentsId('AT122');
        $expense->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $line1 = new ExpenseReportLineCreate();
        $expense->setLines([
            $line1,
        ]);

        $expense->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingLines(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("EE Report must have at least 1 line");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $expense = new ExpenseReportCreate('unittest');
        $expense->setEmployeeId('E0001');
        $expense->setTransactionDate(new \DateTime('2015-06-30'));

        $expense->writeXml($xml);
    }
}
