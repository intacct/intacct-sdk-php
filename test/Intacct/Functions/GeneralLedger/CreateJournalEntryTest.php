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

class CreateJournalEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::writeXml
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

        $journalEntry = new CreateJournalEntry([
            'control_id' => 'unittest',
            'entries' => [
                [
                    // null
                ],
                [
                    // null
                ],
            ],
        ]);
        $journalEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <GLBATCH>
            <JOURNAL>GJ</JOURNAL>
            <BATCH_DATE>06/30/2016</BATCH_DATE>
            <REVERSEDATE>07/01/2016</REVERSEDATE>
            <BATCH_TITLE>My desc</BATCH_TITLE>
            <HISTORY_COMMENT>comment!</HISTORY_COMMENT>
            <REFERENCENO>123</REFERENCENO>
            <BASELOCATION_NO>100</BASELOCATION_NO>
            <SUPDOCID>AT001</SUPDOCID>
            <STATE>Posted</STATE>
            <CUSTOMFIELD01>test01</CUSTOMFIELD01>
            <ENTRIES>
                <GLENTRY>
                    <ACCOUNTNO></ACCOUNTNO>
                    <TRTYPE>1</TRTYPE>
                    <AMOUNT></AMOUNT>
                </GLENTRY>
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

        $journalEntry = new CreateJournalEntry([
            'control_id' => 'unittest',
            'journal_symbol' => 'GJ',
            'posting_date' => new Date('2016-06-30'),
            'reverse_date' => new Date('2016-07-01'),
            'description' => 'My desc',
            'history_comment' => 'comment!',
            'reference_number' => '123',
            'attachments_id' => 'AT001',
            'action' => 'Posted',
            'source_entity_id' => '100',
            'custom_fields' => [
                'CUSTOMFIELD01' => 'test01'
            ],
            'entries' => [
                [
                    // null
                ],
                [
                    // null
                ],
            ],
        ]);
        $journalEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Journal Entry "entries" param must have at least 2 entries
     */
    public function testMissingEntries()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new CreateJournalEntry();

        $journalEntry->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::__construct
     * @covers Intacct\Functions\GeneralLedger\CreateJournalEntry::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Journal Entry "entries" param must have at least 2 entries
     */
    public function testOnlyOneEntry()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new CreateJournalEntry([
            'entries' => [
                [
                    //1
                ],
            ],
        ]);

        $journalEntry->writeXml($xml);
    }
}
