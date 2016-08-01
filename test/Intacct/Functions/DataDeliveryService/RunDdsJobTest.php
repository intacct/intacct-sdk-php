<?php

/**
 * Copyright 2016 Intacct Corporation.
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

class RunDdsJobTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::__construct
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setControlId
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setJobType
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setFileFormat
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setSplitSize
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <runDdsJob>
        <object>GLACCOUNT</object>
        <cloudDelivery>My Cloud Bucket</cloudDelivery>
        <jobType>all</jobType>
        <fileConfiguration>
          <delimiter>,</delimiter>
          <enclosure>"</enclosure>
          <includeHeaders>false</includeHeaders>
          <fileFormat>unix</fileFormat>
          <splitSize>100000</splitSize>
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

        $runJob = new RunDdsJob([
            'object' => 'GLACCOUNT',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'control_id' => 'unittest',
            'job_type' => 'all',
        ]);

        $runJob->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::__construct
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setJobType
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setFileFormat
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setSplitSize
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::writeXml
     */
    public function testParamsOverrides()
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

        $runJob = new RunDdsJob([
            'object' => 'GLACCOUNT',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'control_id' => 'unittest',
            'job_type' => 'change',
            'timestamp' => new DateTime('2002-09-24 06:00'),
            'delimiter' => ',',
            'enclosure' => '"',
            'include_headers' => true,
            'file_format' => 'unix',
            'split_size' => 10000,
            'compress' => false,
        ]);

        $runJob->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::__construct
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setJobType
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage job_type is not a valid type
     */
    public function testNoJobType()
    {
        new RunDdsJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
        ]);
    }

    /**
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::__construct
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setJobType
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setFileFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage file_format is not a valid type
     */
    public function testInvalidFileFormat()
    {
        new RunDdsJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'file_format' => "beos",
        ]);
    }

    /**
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::__construct
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setJobType
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setSplitSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage split_size must be between 10000 and 100000
     */
    public function testMinSplitSize()
    {
        new RunDdsJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'split_size' => 100,
        ]);
    }

    /**
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::__construct
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setJobType
     * @covers Intacct\Functions\DataDeliveryService\RunDdsJob::setSplitSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage split_size must be between 10000 and 100000
     */
    public function testMaxSplitSize()
    {
        new RunDdsJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'split_size' => 100001,
        ]);
    }
}
