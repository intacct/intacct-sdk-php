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
     *
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var string $doc_par_id Document param ID (transaction definition) to read by
     *      @var array $fields Fields to return, default=*
     *      @var array $names Record names to read by
     *      @var string $object Object name to query
     *      @var string $return_format Return format of response, default=xml
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'object' => null,
            'fields' => [],
            'names' => [],
            'return_format' => static::DEFAULT_RETURN_FORMAT,
            'doc_par_id' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->objectName = $config['object'];
        $this->fields = $config['fields'];
        $this->setNames($config['names']);
        $this->setReturnFormat($config['return_format']);
        $this->docParId = $config['doc_par_id'];
    }

    /**
     * Set return format
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
     * Set names
     *
     * @param array $names
     * @throws InvalidArgumentException
     */
    private function setNames(array $names)
    {
        if (count($names) > static::MAX_NAME_COUNT) {
            throw new InvalidArgumentException('names count cannot exceed ' . static::MAX_NAME_COUNT);
        }

        $this->names = $names;
    }
    
    /**
     * Get names for XML
     *
     * @return string
     */
    private function getNamesForXml()
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
    private function getFieldsForXml()
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
        
        $xml->writeElement('object', $this->objectName, true);
        $xml->writeElement('keys', $this->getNamesForXml(), true);
        $xml->writeElement('fields', $this->getFieldsForXml());
        $xml->writeElement('returnFormat', $this->returnFormat);
        $xml->writeElement('docparid', $this->docParId);
        
        $xml->endElement(); //readByName
        
        $xml->endElement(); //function
    }
}
