<?php

/*
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

namespace Intacct\Xml\Request\Operation\Content;

use InvalidArgumentException;

class RecordUpsert extends Record
{
    
    /** @var array */
    private $whereFields = [];
    
    /** @var string */
    private $keyField;

    /**
     *
     * @param array $params
     * @todo Implement this class
     */
    public function __construct(array $params)
    {
        $defaults = [
            'where_fields' => [],
            'key_field' => null,
        ];
        $config = array_merge($defaults, $params);
        
        $this->setWhereFields($config['where_fields']);
        
        $this->setKeyField($config['key_field']);
        
        parent::__construct($config);
    }

    /**
     *
     * @param array $whereFields
     * @throws InvalidArgumentException
     */
    private function setWhereFields($whereFields)
    {
        if (count($whereFields) < 1) {
            throw new InvalidArgumentException(
                'where_fields count must be greater than zero'
            );
        }
        
        foreach ($whereFields as $whereField) {
            if ($this->isValidXmlName($whereField) === false) {
                throw new InvalidArgumentException(
                    'where_field "' . $whereField . '" is not a valid name for an XML element'
                );
            }
            $this->whereFields[] = $whereField;
        }
    }
    
    public function getWhereFields()
    {
        return $this->whereFields;
    }
    
    private function setKeyField($keyField)
    {
        if (!$keyField) {
            throw new InvalidArgumentException(
                'Required "key_field" key not supplied in params'
            );
        }
        $this->keyField = $keyField;
    }
    
    public function getKeyField()
    {
        return $this->keyField;
    }
}
