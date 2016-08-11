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

/**
 * @todo implement filters
 */
class ReadView extends AbstractFunction
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
    
    /** @var string */
    private $viewName;
    
    /** @var int */
    private $pageSize;
    
    /** @var string */
    private $returnFormat;

    /**
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * Set view name
     *
     * @param string $view
     * @throws InvalidArgumentException
     */
    public function setViewName($view)
    {
        if (!is_string($view)) {
            throw new InvalidArgumentException('View Name is not a valid string');
        }

        $this->viewName = $view;
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
     * @param int $pageSize
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
     * @param string $format
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
     * Initializes the class with the given parameters.
     *
     * @param string $controlId
     */
    public function __construct($controlId = null)
    {
        parent::__construct($controlId);

        $this->setPageSize(static::DEFAULT_PAGE_SIZE);
        $this->setReturnFormat(static::DEFAULT_RETURN_FORMAT);
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
            throw new InvalidArgumentException(
                'View Name is required for read view'
            );
        }
        $xml->writeElement('view', $this->getViewName(), true);

        $xml->writeElement('pagesize', $this->getPageSize());
        $xml->writeElement('returnFormat', $this->getReturnFormat());
        
        $xml->endElement(); //readView
        
        $xml->endElement(); //function
    }
}
