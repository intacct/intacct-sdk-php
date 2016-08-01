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
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var int $page_size Max page size 1-1000, default=1000
     *      @var string $return_format Return format of response, default=xml
     *      @var string $view View name to read
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'view' => null,
            'page_size' => static::DEFAULT_PAGE_SIZE,
            'return_format' => static::DEFAULT_RETURN_FORMAT,
            //'filters' => [], //TODO implement filters
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);
        
        if (!$config['view']) {
            throw new InvalidArgumentException(
                'Required "view" key not supplied in params'
            );
        }

        $this->setViewName($config['view']);
        $this->setPageSize($config['page_size']);
        $this->setReturnFormat($config['return_format']);
    }
    
    /**
     * Set page size
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
     * Set view name
     *
     * @param string $view
     * @throws InvalidArgumentException
     */
    private function setViewName($view)
    {
        if (!is_string($view)) {
            throw new InvalidArgumentException('view is not a valid string');
        }

        $this->viewName = $view;
    }

    /**
     * Set return format
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
     * Write the readView block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readView');
        
        $xml->writeElement('view', $this->viewName, true);
        $xml->writeElement('pagesize', $this->pageSize);
        $xml->writeElement('returnFormat', $this->returnFormat);
        
        $xml->endElement(); //readView
        
        $xml->endElement(); //function
    }
}
