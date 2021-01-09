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

class ReadView extends AbstractFunction
{

    /** @var int */
    const MIN_PAGE_SIZE = 1;
    
    /** @var int */
    const MAX_PAGE_SIZE = 1000;
    
    /** @var string */
    private $viewName = '';
    
    /** @var int */
    private $pageSize = 1000;

    /**
     * @return string
     */
    public function getViewName(): string
    {
        return $this->viewName;
    }

    /**
     * @param string $viewName
     */
    public function setViewName(string $viewName)
    {
        $this->viewName = $viewName;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
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
     * Write the readView block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readView');

        if (!$this->getViewName()) {
            throw new \InvalidArgumentException(
                'View Name is required for read view'
            );
        }
        $xml->writeElement('view', $this->getViewName(), true);

        $xml->writeElement('pagesize', $this->getPageSize());
        $xml->writeElement('returnFormat', 'xml');
        
        $xml->endElement(); //readView
        
        $xml->endElement(); //function
    }
}
