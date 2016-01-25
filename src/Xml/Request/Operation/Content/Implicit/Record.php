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

namespace Intacct\Xml\Request\Operation\Content\Implicit;

use ArrayIterator;
use InvalidArgumentException;

class Record extends ArrayIterator
{
    
    use \Intacct\Xml\Request\Operation\Content\XMLHelperTrait;

    /**
     *
     * @var string
     */
    protected $objectName;

    /**
     * 
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params)
    {
        $defaults = [
            'object' => null,
            'fields' => [],
        ];
        $config = array_merge($defaults, $params);

        if (!$config['object']) {
            throw new InvalidArgumentException(
                'Required "object" key not supplied in params'
            );
        }
        
        if (count($config['fields']) < 1) {
            throw new InvalidArgumentException(
                'fields count must be greater than zero'
            );
        }
        
        if ($this->isValidXmlName($config['object']) === false) {
            throw new InvalidArgumentException(
                'object name "' . $config['object'] . '" is not a valid name for an XML element'
            );
        }

        $this->checkFieldKeysAreValidXml($config['fields']);
        
        $this->objectName = $config['object'];

        parent::__construct($config['fields']);
    }
    
    /**
     * 
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

}
