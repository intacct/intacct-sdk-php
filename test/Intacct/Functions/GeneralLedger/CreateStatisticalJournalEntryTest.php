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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateStatisticalJournalEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <GLBATCH>
            <JOURNAL/>
            <BATCH_DATE/>
            <BATCH_TITLE/>
            <ENTRIES>
                <GLENTRY>
                    <ACCOUNTNO/>
                    <TRTYPE>1</TRTYPE>
                    <AMOUNT/>
                </GLENTRY>
            </ENTRIES>
        </GLBATCH>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new CreateStatisticalJournalEntry([
            'control_id' => 'unittest',
            'entries' => [
                [
                    // null
                ],
            ],
        ]);
        $journalEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <GLBATCH>
            <JOURNAL>SJ</JOURNAL>
            <BATCH_DATE>06/30/2016</BATCH_DATE>
            <REVERSEDATE>07/01/2016</REVERSEDATE>
            <BATCH_TITLE>My desc</BATCH_TITLE>
            <HISTORY_COMMENT>comment!</HISTORY_COMMENT>
            <REFERENCENO>123</REFERENCENO>
            <SUPDOCID>AT001</SUPDOCID>
            <STATE>Posted</STATE>
            <CUSTOMFIELD01>test01</CUSTOMFIELD01>
            <ENTRIES>
                <GLENTRY>
                    <ACCOUNTNO></ACCOUNTNO>
                    <TRTYPE>1</TRTYPE>
                    <AMOUNT></AMOUNT>
                </GLENTRY>
            </ENTRIES>
        </GLBATCH>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new CreateStatisticalJournalEntry([
            'control_id' => 'unittest',
            'journal_symbol' => 'SJ',
            'posting_date' => new Date('2016-06-30'),
            'reverse_date' => new Date('2016-07-01'),
            'description' => 'My desc',
            'history_comment' => 'comment!',
            'reference_number' => '123',
            'attachments_id' => 'AT001',
            'action' => 'Posted',
            'custom_fields' => [
                'CUSTOMFIELD01' => 'test01'
            ],
            'entries' => [
                [
                    // null
                ],
            ],
        ]);
        $journalEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Statistical Journal Entry "entries" param must have at least 1 entry
     */
    public function testMissingEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new CreateStatisticalJournalEntry();

        $journalEntry->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateStatisticalJournalEntry::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Statistical Journal Entry "entries" param must have at least 1 entry
     */
    public function testOnlyOneEntry()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new CreateStatisticalJournalEntry([
            'entries' => [
                //none
            ],
        ]);

        $journalEntry->writeXml($xml);
    }
}
