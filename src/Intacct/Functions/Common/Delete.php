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
use Intacct\Xml\Request\Operation\Content\StandardObjects;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Delete extends AbstractFunction
{
    
    /** @var int */
    const MAX_KEY_COUNT = 100;

    /** @var string */
    private $objectName;

    /** @var array */
    private $keys;

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     * @throws InvalidArgumentException
     */
    public function setObjectName($objectName)
    {
        if (in_array('delete', StandardObjects::getMethodsNotAllowed($objectName))) {
            throw new InvalidArgumentException(
                'Using delete on object "' . $objectName . '" is not allowed'
            );
        }

        $this->objectName = $objectName;
    }

    /**
     * @return string
     */
    public function getKeys()
    {
        $keys = implode(',', $this->keys);

        return $keys;
    }

    /**
     * @param array $keys
     * @throws InvalidArgumentException
     */
    public function setKeys(array $keys)
    {
        if (count($keys) > static::MAX_KEY_COUNT) {
            throw new InvalidArgumentException(
                'Keys count cannot exceed ' . static::MAX_KEY_COUNT
            );
        } elseif (count($keys) === 0) {
            throw new InvalidArgumentException(
                'Keys count must be greater than zero'
            );
        }

        $this->keys = $keys;
    }
    
    /**
     * Write the delete block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('delete');
        
        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('keys', $this->getKeys(), true);
        
        $xml->endElement(); //delete
        
        $xml->endElement(); //function
    }
}
