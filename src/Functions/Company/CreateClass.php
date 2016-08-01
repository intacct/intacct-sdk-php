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

namespace Intacct\Functions\Company;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateClass extends AbstractClass
{

    /**
     * @return string
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * @param string $classId
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getParentClassId()
    {
        return $this->parentClassId;
    }

    /**
     * @param string $parentClassId
     */
    public function setParentClassId($parentClassId)
    {
        $this->parentClassId = $parentClassId;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'class_id' => null,
            'class_name' => null,
            'description' => null,
            'parent_class_id' => null,
            'active' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setClassId($config['class_id']);
        $this->setClassName($config['class_name']);
        $this->setDescription($config['description']);
        $this->setParentClassId($config['parent_class_id']);
        $this->setActive($config['active']);
        $this->setCustomFields($config['custom_fields']);
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create');
        $xml->startElement('CLASS');

        if (!$this->getClassId()) {
            throw new InvalidArgumentException('Class ID is required for create');
        }
        $xml->writeElement('CLASSID', $this->getClassId(), true);
        $xml->writeElement('NAME', $this->getClassName(), true);

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('PARENTID', $this->getParentClassId());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //CLASS
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
