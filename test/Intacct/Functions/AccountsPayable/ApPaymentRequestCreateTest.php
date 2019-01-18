<?php

/**
 * Copyright 2019 Sage Intacct, Inc.
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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsPayable\ApPaymentRequestCreate
 */
class ApPaymentRequestCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_paymentrequest>
        <bankaccountid>BA1143</bankaccountid>
        <vendorid>V0001</vendorid>
        <paymentmethod>Printed Check</paymentmethod>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <paymentrequestitems>
            <paymentrequestitem>
                <key>123</key>
                <paymentamount>100.12</paymentamount>
            </paymentrequestitem>
        </paymentrequestitems>
    </create_paymentrequest>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ApPaymentRequestCreate('unittest');
        $payment->setBankAccountId('BA1143');
        $payment->setVendorId('V0001');
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);
        $payment->setPaymentDate(new \DateTime('2015-06-30'));

        $line1 = new ApPaymentRequestItem();
        $line1->setApplyToRecordId(123);
        $line1->setAmountToApply(100.12);
        $payment->setApplyToTransactions([
            $line1,
        ]);

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_paymentrequest>
        <bankaccountid>BA1143</bankaccountid>
        <vendorid>V0001</vendorid>
        <memo>Memo</memo>
        <paymentmethod>Printed Check</paymentmethod>
        <grouppayments>true</grouppayments>
        <paymentdate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </paymentdate>
        <paymentoption>vendorpref</paymentoption>
        <paymentrequestitems>
            <paymentrequestitem>
                <key>123</key>
                <paymentamount>100.12</paymentamount>
                <credittoapply>8.12</credittoapply>
                <discounttoapply>1.21</discounttoapply>
            </paymentrequestitem>
        </paymentrequestitems>
        <documentnumber>10000</documentnumber>
        <paymentdescription>Memo</paymentdescription>
        <paymentcontact>Jim Smith</paymentcontact>
    </create_paymentrequest>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ApPaymentRequestCreate('unittest');
        $payment->setBankAccountId('BA1143');
        $payment->setVendorId('V0001');
        $payment->setMemo('Memo');
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);
        $payment->setGroupPayments(true);
        $payment->setPaymentDate(new \DateTime('2015-06-30'));
        $payment->setMergeOption('vendorpref');
        $payment->setDocumentNo('10000');
        $payment->setNotificationContactName('Jim Smith');

        $line1 = new ApPaymentRequestItem();
        $line1->setApplyToRecordId(123);
        $line1->setAmountToApply(100.12);
        $line1->setCreditToApply(8.12);
        $line1->setDiscountToApply(1.21);
        $payment->setApplyToTransactions([
            $line1,
        ]);

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage AP Payment Request must have at least 1 transaction to apply against
     */
    public function testMissingBillEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $payment = new ApPaymentRequestCreate('unittest');
        $payment->setBankAccountId('BA1143');
        $payment->setVendorId('V0001');
        $payment->setPaymentMethod($payment::PAYMENT_METHOD_CHECK);
        $payment->setPaymentDate(new \DateTime('2015-06-30'));

        $payment->writeXml($xml);
    }
}
