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
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractLocation extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $locationName;

    /** @var string */
    protected $parentLocationId;

    /** @var string */
    protected $managerEmployeeId;

    /** @var string */
    protected $locationContactName;

    /** @var string */
    protected $shipToContactName;

    /** @var Date */
    protected $startDate;

    /** @var Date */
    protected $endDate;

    /** @var string */
    protected $locationTitle;

    /** @var bool */
    protected $active;

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
}
