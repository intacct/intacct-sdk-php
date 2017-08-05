<?php

/**
 * Copyright 2017 Sage Intacct, Inc.
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

class ReadRelated extends AbstractFunction
{

    /** @var array */
    const RETURN_FORMATS = ['xml'];

    /** @var string */
    const DEFAULT_RETURN_FORMAT = 'xml';
    
    /** @var int */
    const MAX_KEY_COUNT = 100;

    /** @var string */
    private $objectName;
    
    /** @var string */
    private $relationName;
    
    /** @var array */
    private $fields;
    
    /** @var array */
    private $keys;
    
    /** @var string */
    private $returnFormat;

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
     * @return string
     */
    public function getRelationName()
    {
        return $this->relationName;
    }

    /**
     * @param string $relationName
     */
    public function setRelationName($relationName)
    {
        $this->relationName = $relationName;
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
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Set keys
     *
     * @param array $keys
     * @throws InvalidArgumentException
     */
    public function setKeys(array $keys)
    {
        if (count($keys) > static::MAX_KEY_COUNT) {
            throw new InvalidArgumentException('Keys count cannot exceed ' . static::MAX_KEY_COUNT);
        }
        $this->keys = $keys;
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
            throw new InvalidArgumentException('Object Name is required for read related');
        }
        $xml->writeElement('object', $this->getObjectName(), true);
        if (!$this->getRelationName()) {
            throw new InvalidArgumentException('Relation Name is required for read related');
        }
        $xml->writeElement('relation', $this->getRelationName(), true);
        $xml->writeElement('keys', $this->writeXmlKeys(), true);
        $xml->writeElement('fields', $this->writeXmlFields());
        $xml->writeElement('returnFormat', $this->getReturnFormat());
        
        $xml->endElement(); //readRelated
        
        $xml->endElement(); //function
    }
}
