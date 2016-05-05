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

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class ReadByName implements FunctionInterface
{
    
    use ControlIdTrait;
    
    /**
     * @var array
     */
    const RETURN_FORMATS = ['xml'];

    /**
     * @var string
     */
    const DEFAULT_RETURN_FORMAT = 'xml';
    
    /**
     * @var int
     */
    const MAX_NAME_COUNT = 100;
    
    /**
     *
     * @var string
     */
    private $objectName;
    
    /**
     *
     * @var array
     */
    private $fields;
    
    /**
     *
     * @var array
     */
    private $names;
    
    /**
     *
     * @var string
     */
    private $returnFormat;

    /**
     *
     * @var string
     */
    private $docParId;

    /**
     * 
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'object' => null,
            'fields' => [],
            'names' => [],
            'return_format' => static::DEFAULT_RETURN_FORMAT,
            'doc_par_id' => null,
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['object']) {
            throw new InvalidArgumentException(
                'Required "object" key not supplied in params'
            );
        }
        
        $this->setControlId($config['control_id']);
        $this->setObject($config['object']);
        $this->setFields($config['fields']);
        $this->setNames($config['names']);
        $this->setReturnFormat($config['return_format']);
        $this->setDocParId($config['doc_par_id']);
    }

    /**
     * @param string $objectName
     * @throws InvalidArgumentException
     */
    private function setObject($objectName)
    {
        if (is_string($objectName) === false)
        {
            throw new InvalidArgumentException('object must be a string');
        }

        $this->objectName = $objectName;
    }


    /**
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
     * 
     * @param array $fields
     */
    private function setFields(array $fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * 
     * @return string
     */
    private function getFields()
    {
        if (count($this->fields) > 0) {
            $fields = implode(',', $this->fields);
        } else {
            $fields = '*';
        }
        
        return $fields;
    }
    
    /**
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
     * 
     * @return string
     */
    private function getNames()
    {
        $names = '';

        if (count($this->names) > 0) {
            $names = implode(',', $this->names);
        }
        
        return $names;
    }

    /**
     * @param string $docParId
     * @throws InvalidArgumentException
     */
    private function setDocParId($docParId)
    {
        if ($docParId !== "" && $docParId !== null && is_string($docParId) === false) {
            throw new InvalidArgumentException('doc_par_id must be a string');
        }

        $this->docParId = $docParId;
    }

    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readByName');
        
        $xml->writeElement('object', $this->objectName, true);
        $xml->writeElement('keys', $this->getNames(), true);
        $xml->writeElement('fields', $this->getFields());
        $xml->writeElement('returnFormat', $this->returnFormat);
        $xml->writeElement('docparid', $this->docParId);
        
        $xml->endElement(); //readByName
        
        $xml->endElement(); //function
    }
    
}
