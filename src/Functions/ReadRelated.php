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

class ReadRelated implements FunctionInterface
{
    
    use ControlIdTrait;

    use ObjectNameTrait;
    
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
    const MAX_KEY_COUNT = 100;
    
    /**
     *
     * @var string
     */
    private $relationName;
    
    /**
     *
     * @var array
     */
    private $fields;
    
    /**
     *
     * @var array
     */
    private $keys;
    
    /**
     *
     * @var string
     */
    private $returnFormat;

    /**
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'object' => null,
            'relation' => null,
            'fields' => [],
            'keys' => [],
            'return_format' => static::DEFAULT_RETURN_FORMAT,
        ];
        $config = array_merge($defaults, $params);

        if (!$config['relation']) {
            throw new InvalidArgumentException(
                'Required "relation" key not supplied in params'
            );
        }
        
        $this->setControlId($config['control_id']);
        $this->setObjectName($config['object']);
        $this->setRelation($config['relation']);
        $this->setFields($config['fields']);
        $this->setKeys($config['keys']);
        $this->setReturnFormat($config['return_format']);
    }

    /**
     * @param string $relation
     * @throws InvalidArgumentException
     */
    private function setRelation($relation)
    {
        if (is_string($relation) === false) {
            throw new InvalidArgumentException('relation must be a string');
        }

        $this->relationName = $relation;
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
     * @param array $fields
     */
    private function setFields(array $fields)
    {
        $this->fields = $fields;
    }
    
    /**
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
     *
     * @param array $keys
     * @throws InvalidArgumentException
     */
    private function setKeys(array $keys)
    {
        if (count($keys) > static::MAX_KEY_COUNT) {
            throw new InvalidArgumentException('keys count cannot exceed ' . static::MAX_KEY_COUNT);
        }
        $this->keys = $keys;
    }
    
    /**
     *
     * @return string
     */
    private function getKeys()
    {
        if (count($this->keys) > 0) {
            $fields = implode(',', $this->keys);
        } else {
            $fields = '';
        }
        
        return $fields;
    }
    
    /**
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readRelated');
        
        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('relation', $this->relationName, true);
        $xml->writeElement('keys', $this->getKeys(), true);
        $xml->writeElement('fields', $this->getFields());
        $xml->writeElement('returnFormat', $this->returnFormat);
        
        $xml->endElement(); //readRelated
        
        $xml->endElement(); //function
    }
}
