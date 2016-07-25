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

use Intacct\Xml\Request\XMLHelperTrait;
use Intacct\Xml\Request\Operation\Content\StandardObjects;
use Intacct\Xml\Request\Operation\Content\Record;
use ArrayIterator;
use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class Update extends ArrayIterator implements FunctionInterface
{
    
    use ControlIdTrait;
    use XMLHelperTrait;
    
    /** @var int */
    const MAX_UPDATE_COUNT = 100;
    
    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var array $records Records to update, @see Record::__construct
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'records' => [],
        ];
        $config = array_merge($defaults, $params);
        
        $this->setControlId($config['control_id']);
        
        if (count($config['records']) > static::MAX_UPDATE_COUNT) {
            throw new InvalidArgumentException(
                'records count cannot exceed ' . static::MAX_UPDATE_COUNT
            );
        } elseif (count($config['records']) < 1) {
            throw new InvalidArgumentException(
                'records count must be greater than zero'
            );
        }

        //TODO change these magic methods
        foreach ($config['records'] as $record) {
            $objectName = $record->getObjectName();
            if (in_array('update', StandardObjects::getMethodsNotAllowed($objectName))) {
                throw new InvalidArgumentException(
                    'using update on object "' . $objectName . '" is not allowed'
                );
            }
        }
        
        parent::__construct($config['records']);
    }

    /**
     * Write the update block XML
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('update');
        
        foreach ($this as $record) {
            $xml->startElement($record->getObjectName());
            $this->recursiveGetXml($record, $xml);
            $xml->endElement();
        }
        
        $xml->endElement(); //update
        
        $xml->endElement(); //function
    }
}
