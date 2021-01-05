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

namespace Intacct\Functions\Common;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

class ReadReport extends AbstractFunction
{

    /** @var int */
    const MIN_PAGE_SIZE = 1;
    
    /** @var int */
    const MAX_PAGE_SIZE = 1000;
    
    /** @var int */
    const MIN_WAIT_TIME = 0;
    
    /** @var int */
    const MAX_WAIT_TIME = 30;
    
    /** @var string */
    private $reportName = '';
    
    /** @var array */
    private $arguments = [];
    
    /** @var int */
    private $pageSize = 1000;
    
    /** @var int */
    private $waitTime = 0;

    /** @var string */
    private $listSeparator = '';

    /** @var bool */
    private $returnDef = false;

    /**
     * @return string
     */
    public function getReportName(): string
    {
        return $this->reportName;
    }

    /**
     * @param string $reportName
     */
    public function setReportName(string $reportName)
    {
        $this->reportName = $reportName;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize Page size
     */
    public function setPageSize(int $pageSize)
    {
        if ($pageSize < static::MIN_PAGE_SIZE) {
            throw new \InvalidArgumentException(
                'Page Size cannot be less than ' . static::MIN_PAGE_SIZE
            );
        }

        if ($pageSize > static::MAX_PAGE_SIZE) {
            throw new \InvalidArgumentException(
                'Page Size cannot be greater than ' . static::MAX_PAGE_SIZE
            );
        }

        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getWaitTime(): int
    {
        return $this->waitTime;
    }

    /**
     * @param int $waitTime Wait time
     */
    public function setWaitTime(int $waitTime)
    {
        if ($waitTime < static::MIN_WAIT_TIME) {
            throw new \InvalidArgumentException(
                'Wait Time cannot be less than ' . static::MIN_WAIT_TIME
            );
        }

        if ($waitTime > static::MAX_WAIT_TIME) {
            throw new \InvalidArgumentException(
                'Wait Time cannot be greater than ' . static::MAX_WAIT_TIME
            );
        }

        $this->waitTime = $waitTime;
    }

    /**
     * @return string
     */
    public function getListSeparator(): string
    {
        return $this->listSeparator;
    }

    /**
     * @param string $listSeparator
     */
    public function setListSeparator(string $listSeparator)
    {
        $this->listSeparator = $listSeparator;
    }

    /**
     * @return bool
     */
    public function isReturnDef(): bool
    {
        return $this->returnDef;
    }

    /**
     * @param bool $returnDef
     */
    public function setReturnDef(bool $returnDef)
    {
        $this->returnDef = $returnDef;
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
            throw new \InvalidArgumentException(
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
            $xml->writeElement('returnFormat', 'xml');
            if ($this->getListSeparator()) {
                $xml->writeElement('listSeparator', $this->getListSeparator());
            }
        }
        $xml->endElement(); //readReport
        
        $xml->endElement(); //function
    }
}
