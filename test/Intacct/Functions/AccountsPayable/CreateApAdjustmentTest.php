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

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class CreateApAdjustmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getExchangeRateInfoXml
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getApAdjustmentEntriesXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_apadjustment>
        <vendorid>VENDOR1</vendorid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <apadjustmentitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </apadjustmentitems>
    </create_apadjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBill = new CreateApAdjustment([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2015-06-30',
            'ap_adjustment_entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getApAdjustmentEntriesXml
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getExchangeRateInfoXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_apadjustment>
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
        <batchkey>20323</batchkey>
        <adjustmentno>234</adjustmentno>
        <action>Submit</action>
        <billno>234235</billno>
        <description>Some description</description>
        <externalid>20394</externalid>
        <basecurr>USD</basecurr>
        <currency>USD</currency>
        <exchratedate>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <nogl>true</nogl>
        <customfields>
            <customfield>
                <customfieldname>customfield1</customfieldname>
                <customfieldvalue>customvalue1</customfieldvalue>
            </customfield>
        </customfields>
        <apadjustmentitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </apadjustmentitems>
    </create_apadjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apAdjustmentEntry = new CreateApAdjustmentEntry([
            'transaction_amount' => 76343.43,
        ]);

        $apBill = new CreateApAdjustment([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2015-06-30',
            'when_posted' => '2015-06-30 06:00',
            'batch_key' => '20323',
            'adjustment_number' => '234',
            'action' => 'Submit',
            'bill_number' => '234235',
            'description' => 'Some description',
            'external_id' => '20394',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => '2015-06-30',
            'exchange_rate_type' => 'Intacct Daily Rate',
            'do_not_post_to_gl' => true,
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'ap_adjustment_entries' => [
                $apAdjustmentEntry,
            ],

        ]);
        $apBill->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::__construct
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getXml
     * @covers Intacct\Functions\AccountsPayable\CreateApAdjustment::getApAdjustmentEntriesXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "ap_adjustment_entries" param must have at least 1 entry
     */
    public function testMissingApAdjustmentEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $apBill = new CreateApAdjustment([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'when_created' => '2015-06-30',
        ]);

        $apBill->getXml($xml);
    }

}
