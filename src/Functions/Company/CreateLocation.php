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

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateLocation extends AbstractLocation
{

    /**
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param string $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return string
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * @param string $locationName
     */
    public function setLocationName($locationName)
    {
        $this->locationName = $locationName;
    }

    /**
     * @return string
     */
    public function getParentLocationId()
    {
        return $this->parentLocationId;
    }

    /**
     * @param string $parentLocationId
     */
    public function setParentLocationId($parentLocationId)
    {
        $this->parentLocationId = $parentLocationId;
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
    public function getLocationContactName()
    {
        return $this->locationContactName;
    }

    /**
     * @param string $locationContactName
     */
    public function setLocationContactName($locationContactName)
    {
        $this->locationContactName = $locationContactName;
    }

    /**
     * @return string
     */
    public function getShipToContactName()
    {
        return $this->shipToContactName;
    }

    /**
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * @return Date
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param Date $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return Date
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param Date $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getLocationTitle()
    {
        return $this->locationTitle;
    }

    /**
     * @param string $locationTitle
     */
    public function setLocationTitle($locationTitle)
    {
        $this->locationTitle = $locationTitle;
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
            'location_id' => null,
            'location_name' => null,
            'parent_location_id' => null,
            'manager_employee_id' => null,
            'location_contact_name' => null,
            'ship_to_contact_name' => null,
            'start_date' => null,
            'end_date' => null,
            'location_title' => null,
            'active' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setLocationId($config['location_id']);
        $this->setLocationName($config['location_name']);
        $this->setParentLocationId($config['parent_location_id']);
        $this->setManagerEmployeeId($config['manager_employee_id']);
        $this->setLocationContactName($config['location_contact_name']);
        $this->setShipToContactName($config['ship_to_contact_name']);
        $this->setStartDate($config['start_date']);
        $this->setEndDate($config['end_date']);
        $this->setLocationTitle($config['location_title']);
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
        $xml->startElement('LOCATION');

        if (!$this->getLocationId()) {
            throw new InvalidArgumentException('Location ID is required for create');
        }
        $xml->writeElement('LOCATIONID', $this->getLocationId(), true);
        $xml->writeElement('NAME', $this->getLocationName(), true);

        $xml->writeElement('PARENTID', $this->getParentLocationId());
        $xml->writeElement('SUPERVISORID', $this->getManagerEmployeeId());

        if ($this->getLocationContactName()) {
            $xml->startElement('CONTACTINFO');
            $xml->writeElement('CONTACTNAME', $this->getLocationContactName());
            $xml->endElement();
        }

        if ($this->getShipToContactName()) {
            $xml->startElement('SHIPTO');
            $xml->writeElement('CONTACTNAME', $this->getShipToContactName());
            $xml->endElement();
        }

        $xml->writeElement('STARTDATE', $this->getStartDate());
        $xml->writeElement('ENDDATE', $this->getEndDate());
        $xml->writeElement('CUSTTITLE', $this->getLocationTitle());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //LOCATION
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
