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

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ReadByName extends AbstractFunction
{

    /** @var array */
    const RETURN_FORMATS = ['xml'];

    /** @var string */
    const DEFAULT_RETURN_FORMAT = 'xml';
    
    /** @var int */
    const MAX_NAME_COUNT = 100;

    /** @var string */
    private $objectName;

    /** @var array */
    private $fields;
    
    /** @var array */
    private $names;
    
    /** @var string */
    private $returnFormat;

    /** @var string */
    private $docParId;

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
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Set names
     *
     * @param array $names
     * @throws InvalidArgumentException
     */
    public function setNames(array $names)
    {
        if (count($names) > static::MAX_NAME_COUNT) {
            throw new InvalidArgumentException('Names count cannot exceed ' . static::MAX_NAME_COUNT);
        }

        $this->names = $names;
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
     * @return string
     */
    public function getDocParId()
    {
        return $this->docParId;
    }

    /**
     * @param string $docParId
     */
    public function setDocParId($docParId)
    {
        $this->docParId = $docParId;
    }
    
    /**
     * Get names for XML
     *
     * @return string
     */
    private function writeXmlNames()
    {
        $names = '';

        if (count($this->names) > 0) {
            $names = implode(',', $this->names);
        }
        
        return $names;
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
     * Write the readByName block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readByName');
        
        $xml->writeElement('object', $this->getObjectName(), true);
        $xml->writeElement('keys', $this->writeXmlNames(), true);
        $xml->writeElement('fields', $this->writeXmlFields());
        $xml->writeElement('returnFormat', $this->getReturnFormat());
        $xml->writeElement('docparid', $this->getDocParId());
        
        $xml->endElement(); //readByName
        
        $xml->endElement(); //function
    }
}
