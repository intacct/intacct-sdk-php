<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Functions\DataDeliveryService;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use DateTime;

/**
 * @coversDefaultClass \Intacct\Functions\DataDeliveryService\DdsJobCreate
 */
class DdsJobCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <runDdsJob>
        <object>GLACCOUNT</object>
        <cloudDelivery>My Cloud Bucket</cloudDelivery>
        <jobType>all</jobType>
        <fileConfiguration/>
    </runDdsJob>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $runJob = new DdsJobCreate('unittest');
        $runJob->setObjectName('GLACCOUNT');
        $runJob->setCloudDeliveryName('My Cloud Bucket');
        $runJob->setJobType('all');

        $runJob->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testParamsOverrides(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <runDdsJob>
        <object>GLACCOUNT</object>
        <cloudDelivery>My Cloud Bucket</cloudDelivery>
        <jobType>change</jobType>
        <timeStamp>2002-09-24T06:00:00</timeStamp>
        <fileConfiguration>
            <delimiter>,</delimiter>
            <enclosure>"</enclosure>
            <includeHeaders>true</includeHeaders>
            <fileFormat>unix</fileFormat>
            <splitSize>10000</splitSize>
            <compress>false</compress>
        </fileConfiguration>
    </runDdsJob>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $runJob = new DdsJobCreate('unittest');
        $runJob->setObjectName('GLACCOUNT');
        $runJob->setCloudDeliveryName('My Cloud Bucket');
        $runJob->setJobType('change');
        $runJob->setTimestamp(new DateTime('2002-09-24 06:00'));
        $runJob->setDelimiter(',');
        $runJob->setEnclosure('"');
        $runJob->setIncludeHeaders(true);
        $runJob->setFileFormat('unix');
        $runJob->setSplitSize(10000);
        $runJob->setCompressed(false);

        $runJob->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testNoJobType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Job Type is not a valid type");

        $runJob = new DdsJobCreate('unittest');
        $runJob->setJobType('test');
    }

    public function testInvalidFileFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File Format is not a valid type");

        $runJob = new DdsJobCreate('unittest');
        $runJob->setFileFormat('beos');
    }

    public function testMinSplitSize(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Split Size must be between 10000 and 100000");

        $runJob = new DdsJobCreate('unittest');
        $runJob->setSplitSize(100);
    }

    public function testMaxSplitSize(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Split Size must be between 10000 and 100000");

        $runJob = new DdsJobCreate('unittest');
        $runJob->setSplitSize(100001);
    }
}
