<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

    /** @var \DateTime */
    protected $startDate;

    /** @var \DateTime */
    protected $endDate;

    /** @var string */
    protected $locationTitle;

    /** @var bool */
    protected $active;

    /**
     * Get location ID
     *
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * Set location ID
     *
     * @param string $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * Get location name
     *
     * @return string
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * Set location name
     *
     * @param string $locationName
     */
    public function setLocationName($locationName)
    {
        $this->locationName = $locationName;
    }

    /**
     * Get parent location ID
     *
     * @return string
     */
    public function getParentLocationId()
    {
        return $this->parentLocationId;
    }

    /**
     * Set parent location ID
     *
     * @param string $parentLocationId
     */
    public function setParentLocationId($parentLocationId)
    {
        $this->parentLocationId = $parentLocationId;
    }

    /**
     * Get manager employee ID
     *
     * @return string
     */
    public function getManagerEmployeeId()
    {
        return $this->managerEmployeeId;
    }

    /**
     * Set manager employee ID
     *
     * @param string $managerEmployeeId
     */
    public function setManagerEmployeeId($managerEmployeeId)
    {
        $this->managerEmployeeId = $managerEmployeeId;
    }

    /**
     * Get location contact name
     *
     * @return string
     */
    public function getLocationContactName()
    {
        return $this->locationContactName;
    }

    /**
     * Set location contact name
     *
     * @param string $locationContactName
     */
    public function setLocationContactName($locationContactName)
    {
        $this->locationContactName = $locationContactName;
    }

    /**
     * Get ship to contact name
     *
     * @return string
     */
    public function getShipToContactName()
    {
        return $this->shipToContactName;
    }

    /**
     * Set ship to contact name
     *
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * Get start date
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set start date
     *
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Get end date
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set end date
     *
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Get location title
     *
     * @return string
     */
    public function getLocationTitle()
    {
        return $this->locationTitle;
    }

    /**
     * Set location title
     *
     * @param string $locationTitle
     */
    public function setLocationTitle($locationTitle)
    {
        $this->locationTitle = $locationTitle;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}
