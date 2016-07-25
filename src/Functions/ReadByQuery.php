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

use InvalidArgumentException;
use Intacct\Functions\Traits\ObjectNameTrait;
use Intacct\Xml\XMLWriter;

class ReadByQuery implements FunctionInterface
{
    
    use ControlIdTrait;

    use ObjectNameTrait;

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

    /** @var array */
    private $fields;
    
    /** @var string */
    private $query;
    
    /** @var int */
    private $pageSize;
    
    /** @var string */
    private $returnFormat;
    
    /** @var string */
    private $docParId;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var string $doc_par_id Document param ID (transaction definition) to read by
     *      @var array $fields Fields to return, default=*
     *      @var string $object Object name to query
     *      @var int $page_size Max page size 1-1000, default=1000
     *      @var string $query Query to filter by
     *      @var string $return_format Return format of response, default=xml
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'object' => null,
            'fields' => [],
            'query' => null,
            'page_size' => static::DEFAULT_PAGE_SIZE,
            'return_format' => static::DEFAULT_RETURN_FORMAT,
            'doc_par_id' => '',
        ];
        $config = array_merge($defaults, $params);
        
        $this->setControlId($config['control_id']);
        $this->setObjectName($config['object']);
        $this->setFields($config['fields']);
        $this->setQuery($config['query']);
        $this->setPageSize($config['page_size']);
        $this->setReturnFormat($config['return_format']);
        $this->setDocParId($config['doc_par_id']);
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
     * Set fields
     *
     * @param array $fields
     */
    private function setFields(array $fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * Get fields
     *
     * @return string
     */
    private function getFields()
    {
        if (count($this->fields) > 0) {
            $fields = implode(',', $this->fields);
        } else {
            $fields = '*';
        }
        
        return $fields;
    }

    /**
     * Set query
     *
     * @param string $query
     * @throws InvalidArgumentException
     */
    private function setQuery($query)
    {
        if (is_string($query) === false) {
            throw new InvalidArgumentException('query must be a string');
        }
        $this->query = $query;
    }

    /**
     * Set doc par ID
     *
     * @param type $docParId
     * @throws InvalidArgumentException
     */
    private function setDocParId($docParId)
    {
        if (is_string($docParId) === false) {
            throw new InvalidArgumentException('doc_par_id must be a string');
        }
        $this->docParId = $docParId;
    }

    /**
     * Write the readByQuery block XML
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readByQuery');
        
        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('query', $this->query, true);
        $xml->writeElement('fields', $this->getFields());
        $xml->writeElement('pagesize', $this->pageSize);
        $xml->writeElement('returnFormat', $this->returnFormat);
        $xml->writeElement('docparid', $this->docParId);
        
        $xml->endElement(); //readByQuery
        
        $xml->endElement(); //function
    }
}
