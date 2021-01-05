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

namespace Intacct\Functions\InventoryControl;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractWarehouse extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $warehouseId;

    /** @var string */
    protected $warehouseName;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $managerEmployeeId;

    /** @var string */
    protected $parentWarehouseId;

    /** @var string */
    protected $warehouseContactName;

    /** @var string */
    protected $shipToContactName;

    /** @var bool */
    protected $usedInGeneralLedger;

    /** @var bool */
    protected $active;

    /**
     * @return string
     */
    public function getWarehouseId()
    {
        return $this->warehouseId;
    }

    /**
     * @param string $warehouseId
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;
    }

    /**
     * @return string
     */
    public function getWarehouseName()
    {
        return $this->warehouseName;
    }

    /**
     * @param string $warehouseName
     */
    public function setWarehouseName($warehouseName)
    {
        $this->warehouseName = $warehouseName;
    }

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
    public function getParentWarehouseId()
    {
        return $this->parentWarehouseId;
    }

    /**
     * @param string $parentWarehouseId
     */
    public function setParentWarehouseId($parentWarehouseId)
    {
        $this->parentWarehouseId = $parentWarehouseId;
    }

    /**
     * @return string
     */
    public function getWarehouseContactName()
    {
        return $this->warehouseContactName;
    }

    /**
     * @param string $warehouseContactName
     */
    public function setWarehouseContactName($warehouseContactName)
    {
        $this->warehouseContactName = $warehouseContactName;
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
     * @return bool
     */
    public function isUsedInGeneralLedger()
    {
        return $this->usedInGeneralLedger;
    }

    /**
     * @param bool $usedInGeneralLedger
     */
    public function setUsedInGeneralLedger($usedInGeneralLedger)
    {
        $this->usedInGeneralLedger = $usedInGeneralLedger;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}
