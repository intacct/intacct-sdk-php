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

namespace Intacct\Functions\DataDeliveryService;

use DateTime;
use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class RunDdsJob extends AbstractFunction
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
     * @var DateTime
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
            'object' => null,
            'cloud_delivery_name' => null,
            'job_type' => null,
            'timestamp' => null,
            'delimiter' => ',',
            'enclosure' => '"',
            'include_headers' => false,
            'file_format' => static::FILE_FORMAT_UNIX,
            'split_size' => static::DEFAULT_SPLIT_SIZE,
            'compress' => false,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->objectName = $config['object'];
        $this->cloudDeliveryName = $config['cloud_delivery_name'];
        $this->setJobType($config['job_type']);
        $this->timestamp = $config['timestamp'];
        $this->delimiter = $config['delimiter'];
        $this->enclosure = $config['enclosure'];
        $this->includeHeaders = $config['include_headers'];
        $this->setFileFormat($config['file_format']);
        $this->setSplitSize($config['split_size']);
        $this->compressed = $config['compress'];
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
     * @param $fileFormat
     * @throws InvalidArgumentException
     */
    private function setFileFormat($fileFormat)
    {
        if (!in_array($fileFormat, static::FILE_FORMATS)) {
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
        if ($splitSize < static::MIN_SPLIT_SIZE || $splitSize > static::MAX_SPLIT_SIZE) {
            throw new InvalidArgumentException(
                'split_size must be between ' . static::MIN_SPLIT_SIZE
                . ' and ' . static::MAX_SPLIT_SIZE
            );
        }
        $this->splitSize = $splitSize;
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('runDdsJob');

        $xml->writeElement('object', $this->objectName, true);
        $xml->writeElement('cloudDelivery', $this->cloudDeliveryName, true);
        $xml->writeElement('jobType', $this->jobType, true);

        if ($this->timestamp) {
            $xml->writeElement('timeStamp', $this->timestamp->format('Y-m-d\TH:i:s'));
        }

        $xml->startElement('fileConfiguration');

        $xml->writeElement('delimiter', $this->delimiter);
        $xml->writeElement('enclosure', $this->enclosure);
        $xml->writeElement('includeHeaders', $this->includeHeaders);
        $xml->writeElement('fileFormat', $this->fileFormat);
        $xml->writeElement('splitSize', $this->splitSize);
        $xml->writeElement('compress', $this->compressed);

        $xml->endElement(); //fileConfiguration

        $xml->endElement(); //runDdsJob

        $xml->endElement(); //function
    }
}
