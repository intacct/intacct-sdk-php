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

namespace Intacct\Functions\DDS;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class RunJobTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setControlId
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setTimestamp
     * @covers Intacct\Functions\DDS\RunJob::getTimestamp
     * @covers Intacct\Functions\DDS\RunJob::setDelimiter
     * @covers Intacct\Functions\DDS\RunJob::setEnclosure
     * @covers Intacct\Functions\DDS\RunJob::setIncludeHeaders
     * @covers Intacct\Functions\DDS\RunJob::setFileFormat
     * @covers Intacct\Functions\DDS\RunJob::setSplitSize
     * @covers Intacct\Functions\DDS\RunJob::setCompressed
     * @covers Intacct\Functions\DDS\RunJob::getXML
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
        <fileConfiguration/>
    </runDdsJob>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $runJob = new RunJob([
            'object' => 'GLACCOUNT',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'control_id' => 'unittest',
            'job_type' => 'all',
        ]);

        $runJob->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setControlId
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setTimestamp
     * @covers Intacct\Functions\DDS\RunJob::getTimestamp
     * @covers Intacct\Functions\DDS\RunJob::setDelimiter
     * @covers Intacct\Functions\DDS\RunJob::setEnclosure
     * @covers Intacct\Functions\DDS\RunJob::setIncludeHeaders
     * @covers Intacct\Functions\DDS\RunJob::setFileFormat
     * @covers Intacct\Functions\DDS\RunJob::setSplitSize
     * @covers Intacct\Functions\DDS\RunJob::setCompressed
     * @covers Intacct\Functions\DDS\RunJob::getXML
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
            <splitSize>1000</splitSize>
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

        $runJob = new RunJob([
            'object' => 'GLACCOUNT',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'control_id' => 'unittest',
            'job_type' => 'change',
            'timestamp' => '2002-09-24 06:00',
            'delimiter' => ',',
            'enclosure' => '"',
            'include_headers' => true,
            'file_format' => 'unix',
            'split_size' => 1000,
            'compress' => false,
        ]);

        $runJob->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage cloud_delivery_name must be a string
     */
    public function testNoCloudDeliveryName()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'job_type' => 'change',
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage job_type is not a valid type
     */
    public function testNoJobType()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setTimestamp
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage timestamp must be a string or DateTime
     */
    public function testInvalidTimestamp()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'timestamp' => 23484923234,
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setDelimiter
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage delimiter must be a string
     */
    public function testInvalidDelimiter()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'delimiter' => 2,
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setEnclosure
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage enclosure must be a string
     */
    public function testInvalidEnclosure()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'enclosure' => 2,
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setIncludeHeaders
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage include_headers must be a bool
     */
    public function testInvalidIncludeHeaders()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'include_headers' => 2,
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setFileFormat
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage file_format is not a valid type
     */
    public function testInvalidFileFormat()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'file_format' => "some other os",
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setSplitSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage split_size not valid int type
     */
    public function testInvalidSplitSize()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'split_size' => "1000",
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setSplitSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage split_size must be between 1 and 100000
     */
    public function testMinSplitSize()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'split_size' => 0,
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setSplitSize
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage split_size must be between 1 and 100000
     */
    public function testMaxSplitSize()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'split_size' => 100001,
        ]);
    }

    /**
     * @covers Intacct\Functions\DDS\RunJob::__construct
     * @covers Intacct\Functions\DDS\RunJob::setObjectName
     * @covers Intacct\Functions\DDS\RunJob::getObjectName
     * @covers Intacct\Functions\DDS\RunJob::setCloudDeliveryName
     * @covers Intacct\Functions\DDS\RunJob::setJobType
     * @covers Intacct\Functions\DDS\RunJob::setCompressed
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage compress not valid bool
     */
    public function testInvalidCompress()
    {
        new RunJob([
            'object' => 'GLACCOUNT',
            'control_id' => 'unittest',
            'cloud_delivery_name' => 'My Cloud Bucket',
            'job_type' => 'change',
            'compress' => "true",
        ]);
    }
}