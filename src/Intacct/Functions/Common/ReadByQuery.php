<?php

/**
 * Copyright 2017 Intacct Corporation.
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
use Intacct\Functions\Common\Query\ConditionInterface;
use Intacct\Functions\Common\Query\QueryInterface;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ReadByQuery extends AbstractFunction
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
    private $objectName;

    /** @var array */
    private $fields;
    
    /** @var QueryInterface */
    private $query;
    
    /** @var int */
    private $pageSize;
    
    /** @var string */
    private $returnFormat;
    
    /** @var string */
    private $docParId;

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
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return QueryInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param QueryInterface $query
     */
    public function setQuery(QueryInterface $query)
    {
        $this->query = $query;
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
     * @return string
     */
    public function getDocParId()
    {
        return $this->docParId;
    }

    /**
     * @param string $docParId
     */
    public function setDocParId($docParId)
    {
        $this->docParId = $docParId;
    }

    public function __construct($controlId = null)
    {
        parent::__construct($controlId);

        $this->setPageSize(static::DEFAULT_PAGE_SIZE);
        $this->setReturnFormat(static::DEFAULT_RETURN_FORMAT);
    }
    
    /**
     * Get fields
     *
     * @return string
     */
    private function writeXmlFields()
    {
        if (count($this->fields) > 0) {
            $fields = implode(',', $this->fields);
        } else {
            $fields = '*';
        }
        
        return $fields;
    }

    /**
     * Write the readByQuery block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readByQuery');
        
        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('query', $this->getQuery(), true);
        $xml->writeElement('fields', $this->writeXmlFields());
        $xml->writeElement('pagesize', $this->getPageSize());
        $xml->writeElement('returnFormat', $this->getReturnFormat());
        $xml->writeElement('docparid', $this->getDocParId());
        
        $xml->endElement(); //readByQuery
        
        $xml->endElement(); //function
    }
}
