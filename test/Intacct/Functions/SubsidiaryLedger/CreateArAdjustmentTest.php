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

class CreateArAdjustmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
        <customerid>CUSTOMER1</customerid>
        <datecreated>
            <year>2015</year>
            <month>06</month>
            <day>30</day>
        </datecreated>
        <aradjustmentitems>
            <lineitem>
                <glaccountno/>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new CreateArAdjustment([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2015-06-30'),
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);
        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
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
        <batchkey>20323</batchkey>
        <adjustmentno>234235</adjustmentno>
        <action>Submit</action>
        <invoiceno>234</invoiceno>
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
        <aradjustmentitems>
            <lineitem>
                <glaccountno></glaccountno>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustmentEntry = new CreateArAdjustmentEntry([
            'transaction_amount' => 76343.43,
        ]);

        $arAdjustment = new CreateArAdjustment([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2015-06-30'),
            'gl_posting_date' => new Date('2015-06-30'),
            'batch_key' => '20323',
            'adjustment_number' => '234235',
            'action' => 'Submit',
            'invoice_number' => '234',
            'description' => 'Some description',
            'external_id' => '20394',
            'base_currency' => 'USD',
            'transaction_currency' => 'USD',
            'exchange_rate_date' => new Date('2015-06-30'),
            'exchange_rate_type' => 'Intacct Daily Rate',
            'do_not_post_to_gl' => true,
            'entries' => [
                $arAdjustmentEntry,
            ],

        ]);
        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::writeXml
     */
    public function testExchangeRateDate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
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
        <exchratedate>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype>Intacct Daily Rate</exchratetype>
        <aradjustmentitems>
            <lineitem>
                <glaccountno></glaccountno>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new CreateArAdjustment([
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
        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::writeXml
     */
    public function testExchangeRateAsDate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
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
        <basecurr>USD</basecurr>
        <exchratedate>
            <year>2016</year>
            <month>06</month>
            <day>30</day>
        </exchratedate>
        <exchratetype/>
        <aradjustmentitems>
            <lineitem>
                <glaccountno></glaccountno>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new CreateArAdjustment([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
            'transaction_date' => new Date('2016-06-30'),
            'gl_posting_date' => new Date('2016-06-30'),
            'base_currency' => 'USD',
            'exchange_rate_date' => new Date('2016-06-30'),
            'entries' => [
                [
                    'transaction_amount' => 76343.43,
                ],
            ],
        ]);

        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::writeXml
     */
    public function testExchangeRate()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create_aradjustment>
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
        <exchrate>1.522</exchrate>
        <aradjustmentitems>
            <lineitem>
                <glaccountno></glaccountno>
                <amount>76343.43</amount>
            </lineitem>
        </aradjustmentitems>
    </create_aradjustment>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new CreateArAdjustment([
            'control_id' => 'unittest',
            'customer_id' => 'CUSTOMER1',
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
        $arAdjustment->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::__construct
     * @covers Intacct\Functions\SubsidiaryLedger\CreateArAdjustment::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage AR Adjustment "entries" param must have at least 1 entry
     */
    public function testMissingArAdjustmentEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $arAdjustment = new CreateArAdjustment([
            'control_id' => 'unittest',
            'vendor_id' => 'VENDOR1',
            'transaction_date' => new Date('2015-06-30'),
            'payment_term' => 'N30',
        ]);

        $arAdjustment->writeXml($xml);
    }
}
