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
 * @coversDefaultClass \Intacct\Functions\EmployeeExpense\ReimbursementRequestCreate
 */
class ReimbursementRequestCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_reimbursementrequest>
        <bankaccountid>BA1143</bankaccountid>
        <employeeid>E0001</employeeid>
        <paymentmethod>Printed Check</paymentmethod>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <eppaymentrequestitems>
            <eppaymentrequestitem>
                <key>123</key>
                <paymentamount>100.12</paymentamount>
            </eppaymentrequestitem>
        </eppaymentrequestitems>
    </create_reimbursementrequest>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ReimbursementRequestCreate('unittest');
        $payment->setBankAccountId('BA1143');
        $payment->setEmployeeId('E0001');
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);
        $payment->setPaymentDate(new \DateTime('2015-06-30'));

        $line1 = new ReimbursementRequestItem();
        $line1->setApplyToRecordId(123);
        $line1->setAmountToApply(100.12);
        $payment->setApplyToTransactions([
            $line1,
        ]);

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_reimbursementrequest>
        <bankaccountid>BA1143</bankaccountid>
        <employeeid>E0001</employeeid>
        <memo>Memo</memo>
        <paymentmethod>Printed Check</paymentmethod>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <paymentoption>vendorpref</paymentoption>
        <eppaymentrequestitems>
            <eppaymentrequestitem>
                <key>123</key>
                <paymentamount>100.12</paymentamount>
                <credittoapply>8.12</credittoapply>
            </eppaymentrequestitem>
        </eppaymentrequestitems>
        <documentnumber>10000</documentnumber>
        <paymentdescription>Memo</paymentdescription>
        <paymentcontact>Jim Smith</paymentcontact>
    </create_reimbursementrequest>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ReimbursementRequestCreate('unittest');
        $payment->setBankAccountId('BA1143');
        $payment->setEmployeeId('E0001');
        $payment->setMemo('Memo');
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);
        $payment->setPaymentDate(new \DateTime('2015-06-30'));
        $payment->setMergeOption('vendorpref');
        $payment->setDocumentNo('10000');
        $payment->setNotificationContactName('Jim Smith');

        $line1 = new ReimbursementRequestItem();
        $line1->setApplyToRecordId(123);
        $line1->setAmountToApply(100.12);
        $line1->setCreditToApply(8.12);
        $payment->setApplyToTransactions([
            $line1,
        ]);

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingExpenseReportEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("EE Reimbursement Request must have at least 1 transaction to apply against");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ReimbursementRequestCreate('unittest');
        $payment->setBankAccountId('BA1143');
        $payment->setEmployeeId('E0001');
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);
        $payment->setPaymentDate(new \DateTime('2015-06-30'));

        $payment->writeXml($xml);
    }
}
