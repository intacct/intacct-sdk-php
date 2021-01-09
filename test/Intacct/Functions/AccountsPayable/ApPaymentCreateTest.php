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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsPayable\ApPaymentCreate
 */
class ApPaymentCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testGenerateXmlForBill(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Printed Check</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>123</RECORDKEY>
                    <TRX_PAYMENTAMOUNT>100.12</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();

        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 123;
        $line1->paymentAmount = 100.12;

        $detailBuilder->addApPaymentDetailBill($line1);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->paymentMethod = $info::PAYMENT_METHOD_CHECK;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXmlWithBillLine(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>EFT</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <DOCNUMBER>12345</DOCNUMBER>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>123</RECORDKEY>
                    <ENTRYKEY>456</ENTRYKEY>
                    <TRX_PAYMENTAMOUNT>100.12</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();

        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 123;
        $line1->lineRecordNo = 456;
        $line1->paymentAmount = 100.12;

        $detailBuilder->addApPaymentDetailBill($line1);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->documentNo = "12345";
        $info->paymentMethod = $info::PAYMENT_METHOD_RECORD_TRANSFER;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXmlForBillDiscount(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Printed Check</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>123</RECORDKEY>
                    <DISCOUNTDATE>06/29/2015</DISCOUNTDATE>
                    <TRX_PAYMENTAMOUNT>294</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();

        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 123;
        $line1->applyToDiscountDate = new \DateTime('2015-06-29');
        $line1->paymentAmount = 294;

        $detailBuilder->addApPaymentDetailBill($line1);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->paymentMethod = $info::PAYMENT_METHOD_CHECK;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXmlFor2BillDiscount(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Printed Check</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <POSADJKEY>2595</POSADJKEY>
                    <POSADJENTRYKEY>42962</POSADJENTRYKEY>
                    <TRX_PAYMENTAMOUNT>1</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
                <APPYMTDETAIL>
                    <POSADJKEY>2595</POSADJKEY>
                    <POSADJENTRYKEY>42962</POSADJENTRYKEY>
                    <ADJUSTMENTKEY>2590</ADJUSTMENTKEY>
                    <ADJUSTMENTENTRYKEY>42949</ADJUSTMENTENTRYKEY>
                    <TRX_ADJUSTMENTAMOUNT>1.01</TRX_ADJUSTMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();

        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 2595;
        $line1->lineRecordNo = 42962;
        $line1->paymentAmount = 1;

        $line2 = new ApPaymentDetailBillInfo();
        $line2->recordNo = 2595;
        $line2->lineRecordNo = 42962;
        $line2->detailTransaction = (new ApPaymentDetailCreditFactory())->create(
            AbstractApPaymentDetailCredit::DEBIT_MEMO,
            2590,
            42949,
            1.01
        );

        $detailBuilder->addApPaymentDetailCreditMemo($line1);
        $detailBuilder->addApPaymentDetailCreditMemo($line2);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->paymentMethod = $info::PAYMENT_METHOD_CHECK;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXmlForBillAndUseAllThings(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Printed Check</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>30</RECORDKEY>
                    <ENTRYKEY>60</ENTRYKEY>
                    <TRX_PAYMENTAMOUNT>1</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
                <APPYMTDETAIL>
                    <RECORDKEY>30</RECORDKEY>
                    <ENTRYKEY>60</ENTRYKEY>
                    <ADVANCEKEY>2584</ADVANCEKEY>
                    <ADVANCEENTRYKEY>42931</ADVANCEENTRYKEY>
                    <TRX_POSTEDADVANCEAMOUNT>2.49</TRX_POSTEDADVANCEAMOUNT>
                </APPYMTDETAIL>
                <APPYMTDETAIL>
                    <RECORDKEY>30</RECORDKEY>
                    <ENTRYKEY>60</ENTRYKEY>
                    <ADJUSTMENTKEY>2590</ADJUSTMENTKEY>
                    <ADJUSTMENTENTRYKEY>42949</ADJUSTMENTENTRYKEY>
                    <TRX_ADJUSTMENTAMOUNT>2.01</TRX_ADJUSTMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();

        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 30;
        $line1->lineRecordNo = 60;
        $line1->paymentAmount = 1;

        $line2 = new ApPaymentDetailBillInfo();
        $line2->recordNo = 30;
        $line2->lineRecordNo = 60;
        $line2->detailTransaction = (new ApPaymentDetailCreditFactory())->create(
            AbstractApPaymentDetailCredit::ADVANCE,
            2584,
            42931,
            2.49
        );

        $line3 = new ApPaymentDetailBillInfo();
        $line3->recordNo = 30;
        $line3->lineRecordNo = 60;
        $line3->detailTransaction = (new ApPaymentDetailCreditFactory())->create(
            AbstractApPaymentDetailCredit::DEBIT_MEMO,
            2590,
            42949,
            2.01
        );

        $detailBuilder->addApPaymentDetailBill($line1);
        $detailBuilder->addApPaymentDetailBill($line2);
        $detailBuilder->addApPaymentDetailBill($line3);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->paymentMethod = $info::PAYMENT_METHOD_CHECK;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXmlForBillAndUseNegativeBill(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Cash</PAYMENTMETHOD>
            <FINANCIALENTITY>BOA</FINANCIALENTITY>
            <VENDORID>a4</VENDORID>
            <PAYMENTDATE>10/06/2020</PAYMENTDATE>
            <CURRENCY>USD</CURRENCY>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>3693</RECORDKEY>
                    <INLINEKEY>3694</INLINEKEY>
                    <TRX_INLINEAMOUNT>70</TRX_INLINEAMOUNT>
                    <TRX_PAYMENTAMOUNT>8.8</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();
        $lineNumber = null;
        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 3693;
        $line1->paymentAmount = 8.8;
        $line1->detailTransaction = (new ApPaymentDetailCreditFactory())->create(
            AbstractApPaymentDetailCredit::NEGATIVE_BILL,
            3694,
            null,
            70
        );

        $detailBuilder->addApPaymentDetailBill($line1);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BOA';
        $info->vendorId = 'a4';
        $info->paymentMethod = $info::PAYMENT_METHOD_CASH;
        $info->paymentDate = new \DateTime('2020-10-06');
        $info->transactionCurrency = 'USD';
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXml(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Printed Check</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>123</RECORDKEY>
                    <TRX_PAYMENTAMOUNT>100.12</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();
        $lineNumber = null;
        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 123;
        $line1->paymentAmount = 100.12;

        $detailBuilder->addApPaymentDetailBill($line1);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->paymentMethod = $info::PAYMENT_METHOD_CHECK;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testGenerateXmlWithAllParamsForBillDiscount(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <APPYMT>
            <PAYMENTMETHOD>Printed Check</PAYMENTMETHOD>
            <FINANCIALENTITY>BA1143</FINANCIALENTITY>
            <VENDORID>V0001</VENDORID>
            <PAYMENTREQUESTMETHOD>vendorpref</PAYMENTREQUESTMETHOD>
            <GROUPPAYMENTS>true</GROUPPAYMENTS>
            <EXCH_RATE_DATE>06/30/2015</EXCH_RATE_DATE>
            <EXCH_RATE_TYPE_ID>Intacct Daily Rate</EXCH_RATE_TYPE_ID>
            <DOCNUMBER>10000</DOCNUMBER>
            <DESCRIPTION>Memo</DESCRIPTION>
            <PAYMENTCONTACT>Jim Smith</PAYMENTCONTACT>
            <PAYMENTDATE>06/30/2015</PAYMENTDATE>
            <APPYMTDETAILS>
                <APPYMTDETAIL>
                    <RECORDKEY>123</RECORDKEY>
                    <DISCOUNTTOAPPLY>1.21</DISCOUNTTOAPPLY>
                    <CREDITTOAPPLY>8.12</CREDITTOAPPLY>
                    <TRX_PAYMENTAMOUNT>100.12</TRX_PAYMENTAMOUNT>
                </APPYMTDETAIL>
            </APPYMTDETAILS>
        </APPYMT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $detailBuilder = new ApPaymentDetailBuilder();
        $lineNumber = null;
        $line1 = new ApPaymentDetailBillInfo();
        $line1->recordNo = 123;
        $line1->discountToApply = 1.21;
        $line1->paymentAmount = 100.12;
        $line1->creditToApply = 8.12;

        $detailBuilder->addApPaymentDetailBill($line1);

        $info = new ApPaymentInfo();
        $info->financialEntityId = 'BA1143';
        $info->vendorId = 'V0001';
        $info->memo = "Memo";
        $info->paymentMethod = $info::PAYMENT_METHOD_CHECK;
        $info->groupPayments = true;
        $info->paymentDate = new \DateTime('2015-06-30');
        $info->exchangeRateDate = new \DateTime('2015-06-30');
        $info->exchangeRateType = "Intacct Daily Rate";
        $info->mergeOption = "vendorpref";
        $info->documentNo = "10000";
        $info->notificationContactName = "Jim Smith";
        $info->apPaymentDetails = $detailBuilder->getApPaymentDetailList();

        $payment = new ApPaymentCreate($info, 'unittest');

        $payment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
