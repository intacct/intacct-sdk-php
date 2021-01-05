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
use Intacct\Functions\Common\Query\QueryInterface;
use Intacct\Xml\XMLWriter;

class ReadByQuery extends AbstractFunction
{

    /** @var int */
    const MIN_PAGE_SIZE = 1;
    
    /** @var int */
    const MAX_PAGE_SIZE = 1000;

    /** @var string */
    private $objectName = '';

    /** @var array */
    private $fields = [];
    
    /** @var QueryInterface */
    private $query;
    
    /** @var int */
    private $pageSize = 1000;
    
    /** @var string */
    private $docParId = '';

    /**
     * @return string
     */
    public function getObjectName(): string
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     */
    public function setObjectName(string $objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return QueryInterface
     */
    public function getQuery() //: QueryInterface
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
     * @return string
     */
    public function getDocParId(): string
    {
        return $this->docParId;
    }

    /**
     * @param string $docParId
     */
    public function setDocParId(string $docParId)
    {
        $this->docParId = $docParId;
    }
    
    /**
     * @return string
     */
    private function writeXmlFields(): string
    {
        if (count($this->getFields()) > 0) {
            $fields = implode(',', $this->getFields());
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
        $xml->writeElement('returnFormat', 'xml');
        if ($this->getDocParId()) {
            $xml->writeElement('docparid', $this->getDocParId());
        }
        
        $xml->endElement(); //readByQuery
        
        $xml->endElement(); //function
    }
}
