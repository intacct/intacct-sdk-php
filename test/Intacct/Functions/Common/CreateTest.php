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

namespace Intacct\Functions\Common;

use Intacct\FieldTypes\DateType;
use Intacct\FieldTypes\Record;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Common\Create
 */
class CreateTest extends \PHPUnit_Framework_TestCase
{

    public function testWriteXml()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <CLASS>
            <CLASSID>UT01</CLASSID>
            <NAME>Unit Test 01</NAME>
        </CLASS>
    </create>
</function>
EOF;

        $record1 = new Record();
        $record1->setObjectName('CLASS');
        $record1->setFields([
            'CLASSID' => 'UT01',
            'NAME' => 'Unit Test 01',
        ]);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $create = new Create('unittest');
        $create->setRecords([
            $record1,
        ]);

        $create->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Records count cannot exceed 100
     */
    public function testTooManyRecords()
    {
        $records = [];
        for ($i = 1; $i <= 101; $i++) {
            $record = new Record();
            $record->setObjectName('CLASS');
            $record->setFields([
                'CLASSID' => 'UT' . $i,
                'NAME' => 'Unit Test ' . $i,
            ]);

            $records[] = $record;
        }

        $create = new Create();
        $create->setRecords($records);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Records count must be greater than zero
     */
    public function testNoRecords()
    {
        $create = new Create();
        $create->setRecords([]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Using create on object "TIMESHEETENTRY" is not allowed
     */
    public function testNotAllowedObject()
    {
        $record1 = new Record();
        $record1->setObjectName('TIMESHEETENTRY');

        $create = new Create();
        $create->setRecords([
            $record1,
        ]);
    }

    public function testWriteXmlOwnedObject()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <GLBATCH>
            <JOURNAL>GJ</JOURNAL>
            <BATCH_DATE>06/30/2016</BATCH_DATE>
            <BATCH_TITLE>test</BATCH_TITLE>
            <ENTRIES>
                <GLENTRY>
                    <ACCOUNTNO>1000</ACCOUNTNO>
                    <TR_TYPE>1</TR_TYPE>
                    <TRX_AMOUNT>10.12</TRX_AMOUNT>
                </GLENTRY>
                <GLENTRY>
                    <ACCOUNTNO>2000</ACCOUNTNO>
                    <TR_TYPE>-1</TR_TYPE>
                    <TRX_AMOUNT>10.12</TRX_AMOUNT>
                    <ALLOCATION>Custom</ALLOCATION>
                    <SPLIT>
                        <AMOUNT>600</AMOUNT>
                    </SPLIT>
                    <SPLIT>
                        <AMOUNT>400</AMOUNT>
                    </SPLIT>
                </GLENTRY>
            </ENTRIES>
        </GLBATCH>
    </create>
</function>
EOF;

        $entry1 = new Record();
        $entry1->setObjectName('GLENTRY');
        $entry1->setFields([
            'ACCOUNTNO' => '1000',
            'TR_TYPE' => '1',
            'TRX_AMOUNT' => 10.12,
        ]);

        $split1 = new Record();
        $split1->setObjectName('SPLIT');
        $split1->setFields([
            'AMOUNT' => 600,
        ]);

        $split2 = new Record();
        $split2->setObjectName('SPLIT');
        $split2->setFields([
            'AMOUNT' => 400,
        ]);

        $entry2 = new Record();
        $entry2->setObjectName('GLENTRY');
        $entry2->setFields([
            'ACCOUNTNO' => '2000',
            'TR_TYPE' => '-1',
            'TRX_AMOUNT' => 10.12,
            'ALLOCATION' => 'Custom',
            $split1,
            $split2,
        ]);

        $batch = new Record();
        $batch->setObjectName('GLBATCH');
        $batch->setFields([
            'JOURNAL' => 'GJ',
            'BATCH_DATE' => new DateType('2016-06-30'),
            'BATCH_TITLE' => 'test',
            'ENTRIES' => [
                $entry1,
                $entry2,
            ],
        ]);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $create = new Create('unittest');
        $create->setRecords([
            $batch,
        ]);

        $create->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
