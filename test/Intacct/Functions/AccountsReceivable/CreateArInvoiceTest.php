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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Fields\Date;
use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class CreateArInvoiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getExchangeRateInfoXml
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
            'when_created' => '2015-06-30',
            'payment_term' => 'N30',
            'ar_invoice_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arInvoice->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getArInvoiceEntriesXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getExchangeRateInfoXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getTermInfoXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getBillToContactNameXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getShipToContactNameXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getInvoiceDate
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::setInvoiceDate
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
            'when_created' => '2015-06-30',
            'when_posted' => '2015-06-30 06:00',
            'due_date' => '2020-09-24 06:00',
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
            'exchange_rate_date' => '2015-06-30',
            'exchange_rate_type' => 'Intacct Daily Rate',
            'do_not_post_to_gl' => true,
            'attachments_id' => '6942',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'ar_invoice_entries' => [
                $arInvoiceEntry,
            ],

        ]);
        $arInvoice->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::setExchangeRateDate
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getTermInfoXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getArInvoiceEntriesXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getInvoiceDate
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::setInvoiceDate
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
            'when_created' => new Date('2016-06-30'),
            'when_posted' => '2016-06-30',
            'due_date' => '2022-09-24',
            'exchange_rate_date' => '2016-06-30',
            'exchange_rate_type' => 'Intacct Daily Rate',
            'ar_invoice_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arInvoice->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::setExchangeRateDate
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getTermInfoXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getExchangeRateInfoXml
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
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30',
            'payment_term' => 'N30',
            'base_currency' => 'USD',
            'exchange_rate_date' => new Date('2016-06-30'),
            'ar_invoice_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);

        $arInvoice->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::setExchangeRateValue
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getExchangeRateInfoXml
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
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30 06:00',
            'due_date' => '2022-09-24 06:00',
            'exchange_rate' => '1.522',
            'ar_invoice_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arInvoice->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::setExchangeRateValue
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage exchange_rate is not a valid number
     */
    public function testInvalidExchangeRate()
    {
        new CreateArInvoice([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30 06:00',
            'due_date' => '2022-09-24 06:00',
            'exchange_rate' => true,
        ]);
    }

    /**
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::__construct
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getXml
     * @covers Intacct\Functions\AccountsReceivable\CreateArInvoice::getArInvoiceEntriesXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "ar_invoice_entries" param must have at least 1 entry
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
            'when_created' => '2015-06-30',
            'payment_term' => 'N30',
        ]);

        $arInvoice->getXml($xml);
    }
}
