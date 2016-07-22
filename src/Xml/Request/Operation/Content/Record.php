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

use ArrayIterator;
use Intacct\Xml\Request\XMLHelperTrait;
use InvalidArgumentException;

class Record extends ArrayIterator
{
    
    use XMLHelperTrait;

    /** @var string */
    protected $objectName;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $object Object name
     *      @var array $fields Fields of record
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params)
    {
        $defaults = [
            'object' => null,
            'fields' => [],
        ];
        $config = array_merge($defaults, $params);

        /*if (count($config['fields']) < 1) {
            throw new InvalidArgumentException(
                'fields count must be greater than zero'
            );
        }*/
        
        $this->setObjectName($config['object']);
        
        $this->checkFieldKeysAreValidXml($config['fields']);
        
        parent::__construct($config['fields']);
    }
    
    /**
     * Get object name
     *
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }
    
    /**
     * Set object name
     *
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function setObjectName($name)
    {
        if (!$name) {
            throw new InvalidArgumentException(
                'object name was not provided or is invalid'
            );
        }

        if ($this->isValidXmlName($name) === false) {
            throw new InvalidArgumentException(
                'object name "' . $name . '" is not a valid name for an XML element'
            );
        }
        
        $this->objectName = $name;
    }
}
