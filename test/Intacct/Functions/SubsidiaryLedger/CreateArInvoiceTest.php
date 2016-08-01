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

namespace Intacct\Functions\SubsidiaryLedger;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateArInvoiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::writeXml
     */
    public function testDefaultParams()
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

        $arInvoice = new CreateArInvoice([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2015-06-30'),
            'payment_term' => 'N30',
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::writeXml
     */
    public function testParamOverrides()
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
        <nogl>true</nogl>
        <supdocid>6942</supdocid>
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

        $arInvoiceEntry = new CreateArInvoiceEntry([
            'transaction_amount' => 76343.43,
        ]);

        $arInvoice = new CreateArInvoice([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2015-06-30'),
            'gl_posting_date' => new Date('2015-06-30'),
            'due_date' => new Date('2020-09-24'),
            'payment_term' => 'N30',
            'action' => 'Submit',
            'batch_key' => '20323',
            'invoice_number' => '234',
            'reference_number' => '234235',
            'on_hold' => true,
            'description' => 'Some description',
            'external_id' => '20394',
            'bill_to_contact_name' => '28952',
            'ship_to_contact_name' => '289533',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => new Date('2015-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'do_not_post_to_gl' => true,
            'attachments_id' => '6942',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'entries' => [
                $arInvoiceEntry,
            ],

        ]);
        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::writeXml
     */
    public function testExchangeRateDate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_invoice>
        <customerid>CUSTOMER1</customerid>
        <datecreated>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <dateposted>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </dateposted>
        <datedue>
            <year>2022</year>
            <month>09</month>
            <day>24</day>
        </datedue>
        <exchratedate>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <invoiceitems>
            <lineitem>
                <glaccountno></glaccountno>
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

        $arInvoice = new CreateArInvoice([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2016-06-30'),
            'gl_posting_date' => new Date('2016-06-30'),
            'due_date' => new Date('2022-09-24'),
            'exchange_rate_date' => new Date('2016-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::writeXml
     */
    public function testExchangeRateAsDate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_invoice>
        <customerid>CUSTOMER1</customerid>
        <datecreated>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <dateposted>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </dateposted>
        <termname>N30</termname>
        <basecurr>USD</basecurr>
        <exchratedate>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype/>
        <invoiceitems>
            <lineitem>
                <glaccountno></glaccountno>
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

        $arInvoice = new CreateArInvoice([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2016-06-30'),
            'gl_posting_date' => new Date('2016-06-30'),
            'payment_term' => 'N30',
            'base_currency' => 'USD',
            'exchange_rate_date' => new Date('2016-06-30'),
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);

        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::writeXml
     */
    public function testExchangeRate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_invoice>
        <customerid>CUSTOMER1</customerid>
        <datecreated>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <dateposted>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </dateposted>
        <datedue>
            <year>2022</year>
            <month>09</month>
            <day>24</day>
        </datedue>
        <exchrate>1.522</exchrate>
        <invoiceitems>
            <lineitem>
                <glaccountno></glaccountno>
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

        $arInvoice = new CreateArInvoice([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2016-06-30'),
            'gl_posting_date' => new Date('2016-06-30 06:00'),
            'due_date' => new Date('2022-09-24 06:00'),
            'exchange_rate' => '1.522',
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arInvoice->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArInvoice::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage AR Invoice "entries" param must have at least 1 entry
     */
    public function testMissingArInvoiceEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arInvoice = new CreateArInvoice([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'transaction_date' => new Date('2015-06-30'),
            'payment_term' => 'N30',
        ]);

        $arInvoice->writeXml($xml);
    }
}
