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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\GeneralLedger\JournalEntryCreate
 */
class JournalEntryCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
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
                    <TR_TYPE>1</TR_TYPE>
                    <TRX_AMOUNT/>
                </GLENTRY>
                <GLENTRY>
                    <ACCOUNTNO/>
                    <TR_TYPE>1</TR_TYPE>
                    <TRX_AMOUNT/>
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

        $journalEntry = new JournalEntryCreate('unittest');
        $journalEntry->setLines([
            new JournalEntryLineCreate(),
            new JournalEntryLineCreate(),
        ]);

        $journalEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamOverrides(): void
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
                    <TR_TYPE>1</TR_TYPE>
                    <TRX_AMOUNT></TRX_AMOUNT>
                </GLENTRY>
                <GLENTRY>
                    <ACCOUNTNO></ACCOUNTNO>
                    <TR_TYPE>1</TR_TYPE>
                    <TRX_AMOUNT></TRX_AMOUNT>
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

        $journalEntry = new JournalEntryCreate('unittest');
        $journalEntry->setJournalSymbol('GJ');
        $journalEntry->setPostingDate(new \DateTime('2016-06-30'));
        $journalEntry->setReverseDate(new \DateTime('2016-07-01'));
        $journalEntry->setDescription('My desc');
        $journalEntry->setHistoryComment('comment!');
        $journalEntry->setReferenceNumber('123');
        $journalEntry->setAttachmentsId('AT001');
        $journalEntry->setAction('Posted');
        $journalEntry->setSourceEntityId('100');
        $journalEntry->setCustomFields([
            'CUSTOMFIELD01' => 'test01',
        ]);
        $journalEntry->setLines([
            new JournalEntryLineCreate(),
            new JournalEntryLineCreate(),
        ]);

        $journalEntry->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testMissingEntries(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Journal Entry must have at least 2 lines");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new JournalEntryCreate();

        $journalEntry->writeXml($xml);
    }

    public function testOnlyOneEntry(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Journal Entry must have at least 2 lines");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $journalEntry = new JournalEntryCreate();
        $journalEntry->setLines([
            new JournalEntryLineCreate(),
        ]);

        $journalEntry->writeXml($xml);
    }
}
