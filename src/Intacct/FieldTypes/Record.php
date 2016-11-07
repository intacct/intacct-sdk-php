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

namespace Intacct\FieldTypes;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Record
{

    /** @var string */
    protected $objectName;

    /** @var array */
    protected $fields = [];
    
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
        if (!$name || !is_string($name)) {
            throw new InvalidArgumentException(
                'Object Name is not a valid string'
            );
        }

        $this->objectName = $name;
    }

    /**
     * Get fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set fields
     *
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Recurse through array and write XML
     *
     * @param array $array
     * @param XMLWriter $xml
     */
    protected function writeXmlRecursiveArray(array $array, XMLWriter &$xml)
    {
        foreach ($array as $key => $value) {
            if ($value instanceof Record) {
                $value->writeXml($xml);
            } elseif (is_array($value)) {
                $xml->startElement($key);
                $this->writeXmlRecursiveArray($value, $xml);
                $xml->endElement();
            } else {
                $xml->writeElement($key, $value, true);
            }
        }
    }

    /**
     * Write the record block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        if (!$this->getObjectName()) {
            throw new InvalidArgumentException(
                'Object Name is required for the record'
            );
        }
        $xml->startElement($this->getObjectName());

        $this->writeXmlRecursiveArray($this->getFields(), $xml);

        $xml->endElement(); //objectName
    }
}
