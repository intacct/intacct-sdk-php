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

class CreateDepartment extends AbstractDepartment
{

    /**
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * @param string $departmentId
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * @return string
     */
    public function getDepartmentName()
    {
        return $this->departmentName;
    }

    /**
     * @param string $departmentName
     */
    public function setDepartmentName($departmentName)
    {
        $this->departmentName = $departmentName;
    }

    /**
     * @return string
     */
    public function getParentDepartmentId()
    {
        return $this->parentDepartmentId;
    }

    /**
     * @param string $parentDepartmentId
     */
    public function setParentDepartmentId($parentDepartmentId)
    {
        $this->parentDepartmentId = $parentDepartmentId;
    }

    /**
     * @return string
     */
    public function getManagerEmployeeId()
    {
        return $this->managerEmployeeId;
    }

    /**
     * @param string $managerEmployeeId
     */
    public function setManagerEmployeeId($managerEmployeeId)
    {
        $this->managerEmployeeId = $managerEmployeeId;
    }

    /**
     * @return string
     */
    public function getDepartmentTitle()
    {
        return $this->departmentTitle;
    }

    /**
     * @param string $departmentTitle
     */
    public function setDepartmentTitle($departmentTitle)
    {
        $this->departmentTitle = $departmentTitle;
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
            'department_id' => null,
            'department_name' => null,
            'parent_department_id' => null,
            'manager_employee_id' => null,
            'department_title' => null,
            'active' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setDepartmentId($config['department_id']);
        $this->setDepartmentName($config['department_name']);
        $this->setParentDepartmentId($config['parent_department_id']);
        $this->setManagerEmployeeId($config['manager_employee_id']);
        $this->setDepartmentTitle($config['department_title']);
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
        $xml->startElement('DEPARTMENT');

        if (!$this->getDepartmentId()) {
            throw new InvalidArgumentException('Department ID is required for create');
        }
        $xml->writeElement('DEPARTMENTID', $this->getDepartmentId(), true);
        $xml->writeElement('TITLE', $this->getDepartmentName(), true);
        $xml->writeElement('PARENTID', $this->getParentDepartmentId());
        $xml->writeElement('SUPERVISORID', $this->getManagerEmployeeId());
        $xml->writeElement('CUSTTITLE', $this->getDepartmentTitle());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //DEPARTMENT
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
