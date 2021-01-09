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

class ReadRelated extends AbstractFunction
{
    
    /** @var int */
    const MAX_KEY_COUNT = 100;

    /** @var string */
    private $objectName = '';
    
    /** @var string */
    private $relationName = '';
    
    /** @var array */
    private $fields = [];
    
    /** @var array */
    private $keys = [];

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
     * @return string
     */
    public function getRelationName(): string
    {
        return $this->relationName;
    }

    /**
     * @param string $relationName
     */
    public function setRelationName(string $relationName)
    {
        $this->relationName = $relationName;
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
     * @return array
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * @param array $keys
     */
    public function setKeys(array $keys)
    {
        if (count($keys) > static::MAX_KEY_COUNT) {
            throw new \InvalidArgumentException('Keys count cannot exceed ' . static::MAX_KEY_COUNT);
        }
        $this->keys = $keys;
    }

    /**
     * Get fields for XML
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
     * Get keys for XML
     *
     * @return string
     */
    private function writeXmlKeys()
    {
        if (count($this->keys) > 0) {
            $fields = implode(',', $this->keys);
        } else {
            $fields = '';
        }
        
        return $fields;
    }
    
    /**
     * Write the readRelated block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readRelated');

        if (!$this->getObjectName()) {
            throw new \InvalidArgumentException('Object Name is required for read related');
        }
        $xml->writeElement('object', $this->getObjectName(), true);
        if (!$this->getRelationName()) {
            throw new \InvalidArgumentException('Relation Name is required for read related');
        }
        $xml->writeElement('relation', $this->getRelationName(), true);
        $xml->writeElement('keys', $this->writeXmlKeys(), true);
        $xml->writeElement('fields', $this->writeXmlFields());
        $xml->writeElement('returnFormat', 'xml');
        
        $xml->endElement(); //readRelated
        
        $xml->endElement(); //function
    }
}
