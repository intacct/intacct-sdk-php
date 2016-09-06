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

namespace Intacct\Functions\Common;

use Intacct\FieldTypes\Record;
use Intacct\Functions\AbstractFunction;
use Intacct\Xml\Request\Operation\Content\StandardObjects;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Create extends AbstractFunction
{

    /** @var int */
    const MAX_CREATE_COUNT = 100;

    /** @var Record[] */
    protected $records;

    /**
     * @return Record[]
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param Record[] $records
     */
    public function setRecords(array $records)
    {
        if (count($records) > static::MAX_CREATE_COUNT) {
            throw new InvalidArgumentException(
                'Records count cannot exceed ' . static::MAX_CREATE_COUNT
            );
        } elseif (count($records) < 1) {
            throw new InvalidArgumentException(
                'Records count must be greater than zero'
            );
        }

        foreach ($records as $record) {
            $objectName = $record->getObjectName();
            if (in_array('create', StandardObjects::getMethodsNotAllowed($objectName))) {
                throw new InvalidArgumentException(
                    'Using create on object "' . $objectName . '" is not allowed'
                );
            }
        }

        $this->records = $records;
    }

    /**
     * Write the create block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('create');
        
        foreach ($this->getRecords() as $record) {
            $record->writeXml($xml);
        }
        
        $xml->endElement(); //create
        
        $xml->endElement(); //function
    }
}
