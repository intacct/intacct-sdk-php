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

namespace Intacct\Functions\DataDeliveryService;

use DateTime;
use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new DDS job record
 */
class DdsJobCreate extends AbstractFunction
{

    /** @var array */
    const JOB_TYPES = ['all', 'change'];

    /** @var string */
    const JOB_TYPE_ALL = 'all';

    /** @var string */
    const JOB_TYPE_CHANGE = 'change';

    /** @var array */
    const FILE_FORMATS = ['unix', 'windows', 'mac'];

    /** @var string */
    const FILE_FORMAT_UNIX = 'unix';

    /** @var string */
    const FILE_FORMAT_WINDOWS = 'windows';

    /** @var string */
    const FILE_FORMAT_MAC = 'mac';

    /** @var int */
    const MIN_SPLIT_SIZE = 10000;

    /** @var int */
    const MAX_SPLIT_SIZE = 100000;

    /** @var int */
    const DEFAULT_SPLIT_SIZE = 100000;

    /** @var string */
    private $objectName;

    /** @var string */
    private $cloudDeliveryName;

    /** @var string */
    private $jobType;

    /** @var DateTime */
    private $timestamp;

    /** @var string */
    private $delimiter;

    /** @var string */
    private $enclosure;

    /** @var bool */
    private $includeHeaders;

    /** @var string */
    private $fileFormat;

    /** @var string */
    private $splitSize;

    /** @var bool */
    private $compressed;

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * @return string
     */
    public function getCloudDeliveryName()
    {
        return $this->cloudDeliveryName;
    }

    /**
     * @param string $cloudDeliveryName
     */
    public function setCloudDeliveryName($cloudDeliveryName)
    {
        $this->cloudDeliveryName = $cloudDeliveryName;
    }

    /**
     * @return string
     */
    public function getJobType()
    {
        return $this->jobType;
    }

    /**
     * @param string $jobType
     * @throws InvalidArgumentException
     */
    public function setJobType($jobType)
    {
        if (!in_array($jobType, static::JOB_TYPES)) {
            throw new InvalidArgumentException('Job Type is not a valid type');
        }
        $this->jobType = $jobType;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param DateTime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
    }

    /**
     * @return bool
     */
    public function isIncludeHeaders()
    {
        return $this->includeHeaders;
    }

    /**
     * @param bool $includeHeaders
     */
    public function setIncludeHeaders($includeHeaders)
    {
        $this->includeHeaders = $includeHeaders;
    }

    /**
     * @return string
     */
    public function getFileFormat()
    {
        return $this->fileFormat;
    }

    /**
     * @param $fileFormat
     * @throws InvalidArgumentException
     */
    public function setFileFormat($fileFormat)
    {
        if (!in_array($fileFormat, static::FILE_FORMATS)) {
            throw new InvalidArgumentException('File Format is not a valid type');
        }
        $this->fileFormat = $fileFormat;
    }

    /**
     * @return string
     */
    public function getSplitSize()
    {
        return $this->splitSize;
    }

    /**
     * @param $splitSize
     * @throws InvalidArgumentException
     */
    public function setSplitSize($splitSize)
    {
        if ($splitSize < static::MIN_SPLIT_SIZE || $splitSize > static::MAX_SPLIT_SIZE) {
            throw new InvalidArgumentException(
                'Split Size must be between ' . static::MIN_SPLIT_SIZE
                . ' and ' . static::MAX_SPLIT_SIZE
            );
        }
        $this->splitSize = $splitSize;
    }

    /**
     * @return bool
     */
    public function isCompressed()
    {
        return $this->compressed;
    }

    /**
     * @param bool $compressed
     */
    public function setCompressed($compressed)
    {
        $this->compressed = $compressed;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('runDdsJob');

        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('cloudDelivery', $this->getCloudDeliveryName(), true);
        $xml->writeElement('jobType', $this->getJobType(), true);

        if ($this->getTimestamp()) {
            $xml->writeElement('timeStamp', $this->getTimestamp()->format('Y-m-d\TH:i:s'));
        }

        $xml->startElement('fileConfiguration');

        $xml->writeElement('delimiter', $this->getDelimiter());
        $xml->writeElement('enclosure', $this->getEnclosure());
        $xml->writeElement('includeHeaders', $this->isIncludeHeaders());
        $xml->writeElement('fileFormat', $this->getFileFormat());
        $xml->writeElement('splitSize', $this->getSplitSize());
        $xml->writeElement('compress', $this->isCompressed());

        $xml->endElement(); //fileConfiguration

        $xml->endElement(); //runDdsJob

        $xml->endElement(); //function
    }
}
