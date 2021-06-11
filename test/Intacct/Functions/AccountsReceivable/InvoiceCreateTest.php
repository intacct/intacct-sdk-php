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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\AccountsReceivable\InvoiceCreate
 */
class InvoiceCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_invoice>
        <customerid>CUSTOMER1</customerid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <termname>N30</termname>
        <invoiceitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </invoiceitems>
    </create_invoice>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arInvoice = new InvoiceCreate('unittest');
        $arInvoice->setCustomerId('CUSTOMER1');
        $arInvoice->setTransactionDate(new \DateTime('2015-06-30'));
        $arInvoice->setPaymentTerm('N30');

        $line1 = new InvoiceLineCreate();
        $line1->setTransactionAmount(76343.43);

        $arInvoice->setLines([
            $line1,
        ]);

        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_invoice>
        <customerid>CUSTOMER1</customerid>
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
        <invoiceno>234</invoiceno>
        <ponumber>234235</ponumber>
        <onhold>true</onhold>
        <description>Some description</description>
        <externalid>20394</externalid>
        <billto>
            <contactname>28952</contactname>
        </billto>
        <shipto>
            <contactname>289533</contactname>
        </shipto>
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
        <invoiceitems>
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
        </invoiceitems>
    </create_invoice>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arInvoice = new InvoiceCreate('unittest');
        $arInvoice->setCustomerId('CUSTOMER1');
        $arInvoice->setTransactionDate(new \DateTime('2015-06-30'));
        $arInvoice->setGlPostingDate(new \DateTime('2015-06-30'));
        $arInvoice->setDueDate(new \DateTime('2020-09-24'));
        $arInvoice->setPaymentTerm('N30');
        $arInvoice->setAction('Submit');
        $arInvoice->setSummaryRecordNo('20323');
        $arInvoice->setInvoiceNumber('234');
        $arInvoice->setReferenceNumber('234235');
        $arInvoice->setOnHold(true);
        $arInvoice->setDescription('Some description');
        $arInvoice->setExternalId('20394');
        $arInvoice->setBillToContactName('28952');
        $arInvoice->setShipToContactName('289533');
        $arInvoice->setBaseCurrency('USD');
        $arInvoice->setTransactionCurrency('USD');
        $arInvoice->setExchangeRateDate(new \DateTime('2015-06-30'));
        $arInvoice->setExchangeRateType('Intacct Daily Rate');
        $arInvoice->setDoNotPostToGL(false);
        $arInvoice->setAttachmentsId('6942');
        $arInvoice->setTaxSolutionId('taxsolution');
        $arInvoice->setCustomFields([
            'customfield1' => 'customvalue1'
        ]);

        $taxEntries = new InvoiceLineTaxEntriesCreate();
        $taxEntries->setTaxId('TaxName');
        $taxEntries->setTaxValue(10);

        $line1 = new InvoiceLineCreate();
        $line1->setTransactionAmount(76343.43);
        $line1->setTaxEntry([$taxEntries]);

        $arInvoice->setLines([
            $line1,
        ]);

        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingInvoiceEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("AR Invoice must have at least 1 line");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arInvoice = new InvoiceCreate('unittest');
        $arInvoice->setCustomerId('CUSTOMER1');
        $arInvoice->setTransactionDate(new \DateTime('2015-06-30'));
        $arInvoice->setPaymentTerm('N30');

        $arInvoice->writeXml($xml);
    }
}
