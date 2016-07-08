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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Fields\Date;
use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class CreateApBillTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getExchangeRateInfoXml
     */
    public function testDefaultParams()
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

        $apBill = new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2015-06-30',
            'payment_term' => 'N30',
            'ap_bill_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getApBillEntriesXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getExchangeRateInfoXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getTermInfoXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getPayToContactNameXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getReturnToContactNameXml
     */
    public function testParamOverrides()
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
        <exchratetype>1.4</exchratetype>
        <nogl>true</nogl>
        <supdocid>6942</supdocid>
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

        $apBillEntry = new CreateApBillEntry([
            'transaction_amount' => 76343.43,
        ]);

        $apBill = new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2015-06-30',
            'when_posted' => '2015-06-30 06:00',
            'due_date' => '2020-09-24 06:00',
            'payment_term' => 'N30',
            'action' => 'Submit',
            'batch_key' => '20323',
            'bill_number' => '234',
            'reference_number' => '234235',
            'on_hold' => true,
            'description' => 'Some description',
            'external_id' => '20394',
            'pay_to_contact_name' => '28952',
            'return_to_contact_name' => '289533',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => '2015-06-30',
            'exchange_rate_type' => '1.4',
            'do_not_post_to_gl' => true,
            'attachments_id' => '6942',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'ap_bill_entries' => [
                $apBillEntry,
            ],

        ]);
        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::setExchangeRateDate
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getTermInfoXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getApBillEntriesXml
     */
    public function testExchangeRateDate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_bill>
        <vendorid>VENDOR1</vendorid>
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
        <billitems>
            <lineitem>
                <glaccountno></glaccountno>
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

        $apBill = new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30',
            'due_date' => '2022-09-24',
            'exchange_rate_date' => '2016-06-30',
            'exchange_rate_type' => 'Intacct Daily Rate',
            'ap_bill_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::setExchangeRateDate
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getTermInfoXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getExchangeRateInfoXml
     */
    public function testExchangeRateAsDate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_bill>
        <vendorid>VENDOR1</vendorid>
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
        <billitems>
            <lineitem>
                <glaccountno></glaccountno>
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

        $apBill = new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30',
            'payment_term' => 'N30',
            'base_currency' => 'USD',
            'exchange_rate_date' => new Date('2016-06-30'),
            'ap_bill_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);

        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::setExchangeRateValue
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getExchangeRateInfoXml
     */
    public function testExchangeRate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_bill>
        <vendorid>VENDOR1</vendorid>
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
        <billitems>
            <lineitem>
                <glaccountno></glaccountno>
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

        $apBill = new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30 06:00',
            'due_date' => '2022-09-24 06:00',
            'exchange_rate' => '1.522',
            'ap_bill_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::setExchangeRateValue
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage exchange_rate is not a valid number
     */
    public function testInvalidExchangeRate()
    {
        new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2016-06-30',
            'when_posted' => '2016-06-30 06:00',
            'due_date' => '2022-09-24 06:00',
            'exchange_rate' => true,
        ]);
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApBill::getApBillEntriesXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "ap_bill_entries" param must have at least 1 entry
     */
    public function testMissingApBillEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBill = new CreateApBill([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2015-06-30',
            'payment_term' => 'N30',
        ]);

        $apBill->getXml($xml);
    }

}