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

namespace Intacct\Functions\DDS;

use DateTime;
use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\ObjectNameTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class RunJob implements FunctionInterface
{

    use ControlIdTrait;
    use ObjectNameTrait;

    /**
     * @var array
     */
    const JOB_TYPES = ['all', 'change'];

    /**
     * @var array
     */
    const FILE_FORMATS = ['unix', 'windows', 'mac'];

    /**
     *
     * @var string
     */
    private $cloudDeliveryName;

    /**
     * @var string
     */
    private $jobType;

    /**
     * @var string|DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var bool
     */
    private $includeHeaders;

    /**
     * @var string
     */
    private $fileFormat;

    /**
     * @var string
     */
    private $splitSize;

    /**
     * @var bool
     */
    private $compressed;

    /**
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'object' => null,
            'cloud_delivery_name' => null,
            'job_type' => null,
            'timestamp' => null,
            'delimiter' => null,
            'enclosure' => null,
            'include_headers' => null,
            'file_format' => null,
            'split_size' => null,
            'compress' => null,
        ];

        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);
        $this->setObjectName($config['object']);
        $this->setCloudDeliveryName($config['cloud_delivery_name']);
        $this->setJobType($config['job_type']);
        $this->setTimestamp($config['timestamp']);
        $this->setDelimiter($config['delimiter']);
        $this->setEnclosure($config['enclosure']);
        $this->setIncludeHeaders($config['include_headers']);
        $this->setFileFormat($config['file_format']);
        $this->setSplitSize($config['split_size']);
        $this->setCompressed($config['compress']);
    }

    /**
     * @param $cloudDeliveryName
     * @throws InvalidArgumentException
     */
    private function setCloudDeliveryName($cloudDeliveryName)
    {
        if (is_string($cloudDeliveryName) == false) {
            throw new InvalidArgumentException('cloud_delivery_name must be a string');
        }

        $this->cloudDeliveryName = $cloudDeliveryName;
    }

    /**
     * @param string $jobType
     * @throws InvalidArgumentException
     */
    private function setJobType($jobType)
    {
        if (!in_array($jobType, static::JOB_TYPES)) {
            throw new InvalidArgumentException('job_type is not a valid type');
        }
        $this->jobType = $jobType;
    }

    /**
     * @param string|DateTime $timestamp
     * @throws InvalidArgumentException
     */
    private function setTimestamp($timestamp)
    {
        if ($timestamp instanceof DateTime || is_null($timestamp)) {
            $this->timestamp = $timestamp;
        } else if (is_string($timestamp) == false) {
            throw new InvalidArgumentException('timestamp must be a string or DateTime');
        } else {
            $this->timestamp = new DateTime($timestamp);
        }
    }

    /**
     * returns string
     */
    private function getTimestamp()
    {
        if (is_null($this->timestamp)) {
            return $this->timestamp;
        }

        return $this->timestamp->format('Y-m-d\TH:i:s');
    }

    /**
     * @param string $delimiter
     * @throws InvalidArgumentException
     */
    private function setDelimiter($delimiter)
    {
        if (is_null($delimiter) == false && is_string($delimiter) == false) {
            throw new InvalidArgumentException('delimiter must be a string');
        }

        $this->delimiter = $delimiter;
    }

    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     */
    private function setEnclosure($enclosure)
    {
        if (is_null($enclosure) == false && is_string($enclosure) == false) {
            throw new InvalidArgumentException('enclosure must be a string');
        }

        $this->enclosure = $enclosure;
    }

    /**
     * @param  bool $includeHeaders
     * @throws InvalidArgumentException
     */
    private function setIncludeHeaders($includeHeaders)
    {
        if (is_null($includeHeaders) == false && is_bool($includeHeaders) == false) {
            throw new InvalidArgumentException('include_headers must be a bool');
        }

        $this->includeHeaders = $includeHeaders;
    }

    /**
     * @param $fileFormat
     * @throws InvalidArgumentException
     */
    private function setFileFormat($fileFormat)
    {
        if (is_null($fileFormat) == false && !in_array($fileFormat, static::FILE_FORMATS)) {
            throw new InvalidArgumentException('file_format is not a valid type');
        }

        $this->fileFormat = $fileFormat;
    }

    /**
     * @param $splitSize
     * @throws InvalidArgumentException
     */
    private function setSplitSize($splitSize)
    {
        if (is_null($splitSize) == false && !is_int($splitSize)) {
            throw new InvalidArgumentException(
                'split_size not valid int type'
            );
        }

        if (($splitSize > 100000 || $splitSize <= 0) && is_null($splitSize) == false) {
            throw new InvalidArgumentException(
                'split_size must be between 1 and 100000'
            );
        } else {
            $this->splitSize = $splitSize;
        }

    }

    /**
     * @param $compressed
     * @throws InvalidArgumentException
     */
    private function setCompressed($compressed)
    {
        if (is_null($compressed) == false && is_bool($compressed) == false) {
            throw new InvalidArgumentException(
                'compress not valid bool'
            );
        }

        $this->compressed = $compressed;
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('runDdsJob');

        $xml->writeElement('object', $this->getObjectName(), true); //required
        $xml->writeElement('cloudDelivery', $this->cloudDeliveryName, true); //required
        $xml->writeElement('jobType', $this->jobType, true); //required
        $xml->writeElement('timeStamp', $this->getTimestamp()); //optional

        $xml->startElement('fileConfiguration'); //optional

        $xml->writeElement('delimiter', $this->delimiter); //optional
        $xml->writeElement('enclosure', $this->enclosure); //optional
        $xml->writeElement('includeHeaders', $this->includeHeaders); //optional
        $xml->writeElement('fileFormat', $this->fileFormat); //optional
        $xml->writeElement('splitSize', $this->splitSize); //optional
        $xml->writeElement('compress', $this->compressed); //optional

        $xml->endElement(); //fileConfiguration

        $xml->endElement(); //runDdsJob

        $xml->endElement(); //function
    }
}