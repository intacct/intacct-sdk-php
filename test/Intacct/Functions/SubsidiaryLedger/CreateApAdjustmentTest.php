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

class CreateApAdjustmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustment::writeXml
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
            'transaction_date' => new Date('2015-06-30'),
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
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustment::writeXml
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
            'transaction_date' => new Date('2015-06-30'),
            'gl_posting_date' => new Date('2015-06-30'),
            'batch_key' => '20323',
            'adjustment_number' => '234',
            'action' => 'Submit',
            'bill_number' => '234235',
            'description' => 'Some description',
            'external_id' => '20394',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => new Date('2015-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'do_not_post_to_gl' => true,
            'custom_fields' => [
                'customfield1' => 'customvalue1'
            ],
            'entries' => [
                $apAdjustmentEntry,
            ],

        ]);
        $apBill->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateApAdjustment::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage "entries" param must have at least 1 entry
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
            'transaction_date' => new Date('2015-06-30'),
        ]);

        $apBill->writeXml($xml);
    }
}
