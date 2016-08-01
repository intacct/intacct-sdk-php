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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Xml\XMLWriter;

class CustomAllocationSplit extends AbstractCustomAllocationSplit
{

    /**
     * @return float|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

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
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

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
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @param string $contractId
     */
    public function setContractId($contractId)
    {
        $this->contractId = $contractId;
    }

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
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var float|string $amount
     *      @var string $location_id
     *      @var string $department_id
     *      @var string $project_id
     *      @var string $customer_id
     *      @var string $vendor_id
     *      @var string $employee_id
     *      @var string $item_id
     *      @var string $class_id
     *      @var string $contract_id
     *      @var string $warehouse_id
     * }
     * @todo add support for user defined dimensions
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'amount' => null,
            'location_id' => null,
            'department_id' => null,
            'project_id' => null,
            'customer_id' => null,
            'vendor_id' => null,
            'employee_id' => null,
            'item_id' => null,
            'class_id' => null,
            'contract_id' => null,
            'warehouse_id' => null,
        ];

        $config = array_merge($defaults, $params);

        $this->setAmount($config['amount']);
        $this->setLocationId($config['location_id']);
        $this->setDepartmentId($config['department_id']);
        $this->setProjectId($config['project_id']);
        $this->setCustomerId($config['customer_id']);
        $this->setVendorId($config['vendor_id']);
        $this->setEmployeeId($config['employee_id']);
        $this->setItemId($config['item_id']);
        $this->setClassId($config['class_id']);
        $this->setContractId($config['contract_id']);
        $this->setWarehouseId($config['warehouse_id']);
    }

    /**
     * Write the SPLIT block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('SPLIT');

        $xml->writeElement('AMOUNT', $this->getAmount(), true);

        $xml->writeElement('LOCATIONID', $this->getLocationId());
        $xml->writeElement('DEPARTMENTID', $this->getDepartmentId());
        $xml->writeElement('PROJECTID', $this->getProjectId());
        $xml->writeElement('CUSTOMERID', $this->getCustomerId());
        $xml->writeElement('VENDORID', $this->getVendorId());
        $xml->writeElement('EMPLOYEEID', $this->getEmployeeId());
        $xml->writeElement('ITEMID', $this->getItemId());
        $xml->writeElement('CLASSID', $this->getClassId());
        $xml->writeElement('CONTRACTID', $this->getContractId());
        $xml->writeElement('WAREHOUSEID', $this->getWarehouseId());

        $xml->endElement(); //SPLIT
    }
}
