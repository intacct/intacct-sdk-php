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
use InvalidArgumentException;
use XMLWriter;

class Create extends ArrayIterator implements FunctionInterface
{

    use XMLHelperTrait;

    /**
     * @var int
     */
    const MAX_CREATE_COUNT = 100;

    /**
     *
     * @var string
     */
    private $controlId;

    /**
     * 
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => 'create',
            'records' => [],
        ];
        $config = array_merge($defaults, $params);
        
        $this->controlId = $config['control_id'];
        
        if (count($config['records']) > static::MAX_CREATE_COUNT) {
            throw new InvalidArgumentException(
                'records count cannot exceed ' . static::MAX_CREATE_COUNT
            );
        } else if (count($config['records']) < 1) {
            throw new InvalidArgumentException(
                'records count must be greater than zero'
            );
        }

        foreach ($config['records'] as $record) {
            $objectName = $record->getObjectName();
            if (in_array('create', StandardObjects::getMethodsNotAllowed($objectName))) {
                throw new InvalidArgumentException(
                    'using create on object "' . $objectName . '" is not allowed'
                );
            }
        }
        
        parent::__construct($config['records']);
    }

    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId);
        
        $xml->startElement('create');
        
        foreach ($this as $record) {
            $xml->startElement($record->getObjectName());
            $this->recursiveGetXml($record, $xml);
            $xml->endElement();
        }
        
        $xml->endElement(); //create
        
        $xml->endElement(); //function
    }
    
}
