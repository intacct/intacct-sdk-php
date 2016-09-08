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

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ReadReport extends AbstractFunction
{
    
    /** @var array */
    const RETURN_FORMATS = ['xml'];

    /** @var string */
    const DEFAULT_RETURN_FORMAT = 'xml';
    
    /** @var int */
    const MIN_PAGE_SIZE = 1;
    
    /** @var int */
    const MAX_PAGE_SIZE = 1000;
    
    /** @var int */
    const DEFAULT_PAGE_SIZE = 1000;
    
    /** @var int */
    const MIN_WAIT_TIME = 0;
    
    /** @var int */
    const MAX_WAIT_TIME = 30;
    
    /** @var int */
    const DEFAULT_WAIT_TIME = 0;
    
    /** @var string */
    private $reportName;
    
    /** @var array */
    private $arguments;
    
    /** @var int */
    private $pageSize;
    
    /** @var string */
    private $returnFormat;
    
    /** @var int */
    private $waitTime;

    /** @var string */
    private $listSeparator;

    /** @var bool */
    private $returnDef;

    /**
     * @return string
     */
    public function getReportName()
    {
        return $this->reportName;
    }

    /**
     * Set report name
     *
     * @param string $report Report name
     * @throws InvalidArgumentException
     */
    public function setReportName($report)
    {
        if (is_string($report) === false) {
            throw new InvalidArgumentException(
                'Report Name must be a string'
            );
        }

        $this->reportName = $report;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @todo change this to a class
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Set page size
     *
     * @param int $pageSize Page size
     * @throws InvalidArgumentException
     */
    public function setPageSize($pageSize)
    {
        if (!is_int($pageSize)) {
            throw new InvalidArgumentException(
                'Page Size not valid int type'
            );
        }

        if ($pageSize < static::MIN_PAGE_SIZE) {
            throw new InvalidArgumentException(
                'Page Size cannot be less than ' . static::MIN_PAGE_SIZE
            );
        }

        if ($pageSize > static::MAX_PAGE_SIZE) {
            throw new InvalidArgumentException(
                'Page Size cannot be greater than ' . static::MAX_PAGE_SIZE
            );
        }

        $this->pageSize = $pageSize;
    }

    /**
     * @return string
     */
    public function getReturnFormat()
    {
        return $this->returnFormat;
    }

    /**
     * Set return format
     *
     * @param string $format Return format
     * @throws InvalidArgumentException
     */
    public function setReturnFormat($format)
    {
        if (!in_array($format, static::RETURN_FORMATS)) {
            throw new InvalidArgumentException('Return Format is not a valid format');
        }
        $this->returnFormat = $format;
    }

    /**
     * @return int
     */
    public function getWaitTime()
    {
        return $this->waitTime;
    }

    /**
     * Set wait time
     *
     * @param int $waitTime Wait time
     * @throws InvalidArgumentException
     */
    public function setWaitTime($waitTime)
    {
        if (!is_int($waitTime)) {
            throw new InvalidArgumentException(
                'Wait Time not valid int type'
            );
        }

        if ($waitTime < static::MIN_WAIT_TIME) {
            throw new InvalidArgumentException(
                'Wait Time cannot be less than ' . static::MIN_WAIT_TIME
            );
        }

        if ($waitTime > static::MAX_WAIT_TIME) {
            throw new InvalidArgumentException(
                'Wait Time cannot be greater than ' . static::MAX_WAIT_TIME
            );
        }

        $this->waitTime = $waitTime;
    }

    /**
     * @return string
     */
    public function getListSeparator()
    {
        return $this->listSeparator;
    }

    /**
     * Set list separator
     *
     * @param string $listSeparator
     * @throws InvalidArgumentException
     */
    public function setListSeparator($listSeparator)
    {
        if (is_string($listSeparator) === false) {
            throw new InvalidArgumentException('List Separator must be a string');
        }

        $this->listSeparator = $listSeparator;
    }

    /**
     * @param bool $returnDef
     */
    public function setReturnDef($returnDef)
    {
        $this->returnDef = $returnDef;
    }

    /**
     * @return boolean
     */
    public function isReturnDef()
    {
        return $this->returnDef;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param string $controlId
     */
    public function __construct($controlId = null)
    {
        parent::__construct($controlId);

        $this->setPageSize(static::DEFAULT_PAGE_SIZE);
        $this->setReturnFormat(static::DEFAULT_RETURN_FORMAT);
        $this->setWaitTime(static::DEFAULT_WAIT_TIME);
    }

    /**
     * @return string
     */
    private function writeXmlReturnDef()
    {
        return $this->isReturnDef() === true ? "true" : null;
    }

    /**
     * Recurse through arguments write XML
     *
     * @param array $array
     * @param XMLWriter $xml
     */
    protected function writeXmlArguments($array, XMLWriter &$xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $xml->startElement($key);
                $this->writeXmlArguments($value, $xml);
                $xml->endElement();
            } else {
                $xml->writeElement($key, $value, true);
            }
        }
    }

    /**
     * Write the readReport block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readReport');

        if (!$this->getReportName()) {
            throw new InvalidArgumentException(
                'Report Name is required for read report'
            );
        }

        if ($this->returnDef === true) {
            $xml->writeAttribute('returnDef', $this->writeXmlReturnDef());
            $xml->writeElement('report', $this->getReportName(), true);
        } else {
            $xml->writeElement('report', $this->getReportName(), true);
            if (count($this->getArguments()) > 0) {
                $xml->startElement('arguments');
                $this->writeXmlArguments($this->getArguments(), $xml);
                $xml->endElement(); //arguments
            }
            $xml->writeElement('waitTime', $this->getWaitTime());
            $xml->writeElement('pagesize', $this->getPageSize());
            $xml->writeElement('returnFormat', $this->getReturnFormat());
            $xml->writeElement('listSeparator', $this->getListSeparator());
        }
        $xml->endElement(); //readReport
        
        $xml->endElement(); //function
    }
}
