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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\FieldTypes\DateType;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ExpenseReportReverseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\EmployeeExpense\ExpenseReportReverse::writeXml
     */
    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <reverse_expensereport key="1234">
        <datereversed>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datereversed>
    </reverse_expensereport>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ExpenseReportReverse('unittest');
        $record->setRecordNo(1234);
        $record->setReverseDate(new DateType('2015-06-30'));

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\EmployeeExpense\ExpenseReportReverse::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Record No is required for reverse
     */
    public function testRequiredId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ExpenseReportReverse('unittest');

        $record->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\EmployeeExpense\ExpenseReportReverse::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Reverse Date is required for reverse
     */
    public function testRequiredDate()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new ExpenseReportReverse('unittest');
        $record->setRecordNo(1234);

        $record->writeXml($xml);
    }
}
