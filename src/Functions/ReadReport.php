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

namespace Intacct\Functions;

use Intacct\Xml\Request\XMLHelperTrait;
use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class ReadReport implements FunctionInterface
{
    
    use ControlIdTrait;
    use XMLHelperTrait;
    
    /**
     * @var array
     */
    const RETURN_FORMATS = ['xml'];

    /**
     * @var string
     */
    const DEFAULT_RETURN_FORMAT = 'xml';
    
    /**
     * @var int
     */
    const MIN_PAGE_SIZE = 1;
    
    /**
     * @var int
     */
    const MAX_PAGE_SIZE = 1000;
    
    /**
     * @var int
     */
    const DEFAULT_PAGE_SIZE = 1000;
    
    /**
     * @var int
     */
    const MIN_WAIT_TIME = 0;
    
    /**
     * @var int
     */
    const MAX_WAIT_TIME = 30;
    
    /**
     * @var int
     */
    const DEFAULT_WAIT_TIME = 0;
    
    /**
     *
     * @var string
     */
    private $reportName;
    
    /**
     *
     * @var array
     */
    private $arguments;
    
    /**
     *
     * @var int
     */
    private $pageSize;
    
    /**
     *
     * @var string
     */
    private $returnFormat;
    
    /**
     *
     * @var int
     */
    private $waitTime;

    /**
     * @var string
     */
    private $listSeparator;

    /**
     * @var bool
     */
    private $returnDef;

    /**
     *
     * @param array $params
     * @todo finish the arguments collection
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'report' => null,
            'arguments' => [],
            'page_size' => static::DEFAULT_PAGE_SIZE,
            'return_format' => static::DEFAULT_RETURN_FORMAT,
            'wait_time' => static::DEFAULT_WAIT_TIME,
            'return_def' => false,
            'list_separator' => '',
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['report']) {
            throw new InvalidArgumentException(
                'Required "report" key not supplied in params'
            );
        }
        
        $this->setControlId($config['control_id']);
        $this->setReportName($config['report']);
        $this->setReturnDef($config['return_def']);
        $this->setArguments($config['arguments']);
        $this->setPageSize($config['page_size']);
        $this->setReturnFormat($config['return_format']);
        $this->setWaitTime($config['wait_time']);
        $this->setListSeparator($config['list_separator']);
    }

    /**
     * @param $report
     * @throws InvalidArgumentException
     */
    private function setReportName($report)
    {
        if (is_string($report) === false) {
            throw new InvalidArgumentException(
                'report must be a string'
            );
        }

        $this->reportName = $report;
    }

    /**
     *
     * @param int $pageSize
     * @throws InvalidArgumentException
     */
    private function setPageSize($pageSize)
    {
        if (!is_int($pageSize)) {
            throw new InvalidArgumentException(
                'page_size not valid int type'
            );
        }
        
        if ($pageSize < static::MIN_PAGE_SIZE) {
            throw new InvalidArgumentException(
                'page_size cannot be less than ' . static::MIN_PAGE_SIZE
            );
        }
        
        if ($pageSize > static::MAX_PAGE_SIZE) {
            throw new InvalidArgumentException(
                'page_size cannot be greater than ' . static::MAX_PAGE_SIZE
            );
        }
        
        $this->pageSize = $pageSize;
    }
    
    /**
     *
     * @param int $waitTime
     * @throws InvalidArgumentException
     */
    private function setWaitTime($waitTime)
    {
        if (!is_int($waitTime)) {
            throw new InvalidArgumentException(
                'wait_time not valid int type'
            );
        }
        
        if ($waitTime < static::MIN_WAIT_TIME) {
            throw new InvalidArgumentException(
                'wait_time cannot be less than ' . static::MIN_WAIT_TIME
            );
        }
        
        if ($waitTime > static::MAX_WAIT_TIME) {
            throw new InvalidArgumentException(
                'wait_time cannot be greater than ' . static::MAX_WAIT_TIME
            );
        }
        
        $this->waitTime = $waitTime;
    }
    
    /**
     *
     * @param string $format
     * @throws InvalidArgumentException
     */
    private function setReturnFormat($format)
    {
        if (!in_array($format, static::RETURN_FORMATS)) {
            throw new InvalidArgumentException('return_format is not a valid format');
        }
        $this->returnFormat = $format;
    }
    
    /**
     *
     * @param array $arguments
     */
    private function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @param string $listSeparator
     * @throws InvalidArgumentException
     */
    private function setListSeparator($listSeparator)
    {
        if (is_string($listSeparator) === false) {
            throw new InvalidArgumentException('list_separator must be a string');
        }

        $this->listSeparator = $listSeparator;
    }

    /**
     * @return string
     */
    private function getListSeparator()
    {
        if ($this->listSeparator === '') {
            return null;
        }

        return $this->listSeparator;
    }

    /**
     * @param $returnDef
     * @throws InvalidArgumentException
     */
    private function setReturnDef($returnDef)
    {
        if (is_bool($returnDef) === false) {
            throw new InvalidArgumentException('return_def must be a bool');
        }

        $this->returnDef = $returnDef;
    }

    /**
     * @return string
     */
    private function getReturnDef()
    {
        return $this->returnDef === true ? "true" : null;
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readReport');

        if ($this->returnDef === true) {
            $xml->writeAttribute('returnDef', $this->getReturnDef());
            $xml->writeElement('report', $this->reportName, true);
        } else {
            $xml->writeElement('report', $this->reportName, true);
            if (count($this->arguments) > 0) {
                $xml->startElement('arguments');
                $this->recursiveGetXml($this->arguments, $xml);
                $xml->endElement(); //arguments
            }
            $xml->writeElement('waitTime', $this->waitTime);
            $xml->writeElement('pagesize', $this->pageSize);
            $xml->writeElement('returnFormat', $this->returnFormat);
            $xml->writeElement('listSeparator', $this->getListSeparator());
        }
        $xml->endElement(); //readReport
        
        $xml->endElement(); //function
    }
}
