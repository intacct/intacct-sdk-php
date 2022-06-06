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
 * @coversDefaultClass \Intacct\Functions\AccountsPayable\BillCreate
 */
class BillCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_bill>
        <vendorid>VENDOR1</vendorid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <termname>N30</termname>
        <billitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </billitems>
    </create_bill>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBill = new BillCreate('unittest');
        $apBill->setVendorId('VENDOR1');
        $apBill->setTransactionDate(new \DateTime('2015-06-30'));
        $apBill->setPaymentTerm('N30');

        $line1 = new BillLineCreate();
        $line1->setTransactionAmount(76343.43);

        $apBill->setLines([
            $line1,
        ]);

        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_bill>
        <vendorid>VENDOR1</vendorid>
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
        <datedue>
            <year>2020</year>
            <month>09</month>
            <day>24</day>
        </datedue>
        <termname>N30</termname>
        <action>Submit</action>
        <batchkey>20323</batchkey>
        <billno>234</billno>
        <ponumber>234235</ponumber>
        <onhold>true</onhold>
        <description>Some description</description>
        <externalid>20394</externalid>
        <payto>
            <contactname>28952</contactname>
        </payto>
        <returnto>
            <contactname>289533</contactname>
        </returnto>
        <basecurr>USD</basecurr>
        <currency>USD</currency>
        <exchratedate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <nogl>false</nogl>
        <supdocid>6942</supdocid>
        <taxsolutionid>taxsolution</taxsolutionid>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <billitems>
            <lineitem>
                <glaccountno></glaccountno>
                <amount>76343.43</amount>
                <taxentries>
                    <taxentry>
                        <detailid>TaxName</detailid>
                        <trx_tax>10</trx_tax>
                    </taxentry>
                </taxentries>
            </lineitem>
        </billitems>
    </create_bill>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBill = new BillCreate('unittest');
        $apBill->setVendorId('VENDOR1');
        $apBill->setTransactionDate(new \DateTime('2015-06-30'));
        $apBill->setGlPostingDate(new \DateTime('2015-06-30'));
        $apBill->setDueDate(new \DateTime('2020-09-24'));
        $apBill->setPaymentTerm('N30');
        $apBill->setAction('Submit');
        $apBill->setSummaryRecordNo(20323);
        $apBill->setBillNumber('234');
        $apBill->setReferenceNumber('234235');
        $apBill->setOnHold(true);
        $apBill->setDescription('Some description');
        $apBill->setExternalId('20394');
        $apBill->setPayToContactName('28952');
        $apBill->setReturnToContactName('289533');
        $apBill->setBaseCurrency('USD');
        $apBill->setTransactionCurrency('USD');
        $apBill->setExchangeRateDate(new \DateTime('2015-06-30'));
        $apBill->setExchangeRateType('Intacct Daily Rate');
        $apBill->setDoNotPostToGL(false);
        $apBill->setAttachmentsId('6942');
        $apBill->setTaxSolutionId('taxsolution');
        $apBill->setCustomFields([
            'customfield1' => 'customvalue1',
        ]);

        $taxEntries = new BillLineTaxEntriesCreate();
        $taxEntries->setTaxId('TaxName');
        $taxEntries->setTaxValue(10);

        $line1 = new BillLineCreate();
        $line1->setTransactionAmount(76343.43);
        $line1->setTaxEntry([$taxEntries]);

        $apBill->setLines([
            $line1,
        ]);

        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingBillEntries()
    {
        $this->expectExceptionMessage("AP Bill must have at least 1 line");
        $this->expectException(InvalidArgumentException::class);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBill = new BillCreate('unittest');
        $apBill->setVendorId('VENDOR1');
        $apBill->setTransactionDate(new \DateTime('2015-06-30'));
        $apBill->setPaymentTerm('N30');

        $apBill->writeXml($xml);
    }
}
