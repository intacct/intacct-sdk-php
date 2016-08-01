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

class CreateApBillTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::writeXml
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
            'transaction_date' => new Date('2015-06-30'),
            'payment_term' => 'N30',
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::writeXml
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
        <exchratetype>Intacct Daily Rate</exchratetype>
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
            'transaction_date' => new Date('2015-06-30'),
            'gl_posting_date' => new Date('2015-06-30'),
            'due_date' => new Date('2020-09-24'),
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
            'exchange_rate_date' => new Date('2015-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'do_not_post_to_gl' => true,
            'attachments_id' => '6942',
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'entries' => [
                $apBillEntry,
            ],

        ]);
        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::writeXml
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
        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::writeXml
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

        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::writeXml
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
            'transaction_date' => new Date('2016-06-30'),
            'gl_posting_date' => new Date('2016-06-30'),
            'due_date' => new Date('2022-09-24'),
            'exchange_rate' => '1.522',
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApBill::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "entries" param must have at least 1 entry
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
            'transaction_date' => new Date('2015-06-30'),
            'payment_term' => 'N30',
        ]);

        $apBill->writeXml($xml);
    }
}
