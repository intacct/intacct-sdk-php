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

class CreateStatisticalJournalEntryEntry extends AbstractGlEntry
{

    /**
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     */
    public function setDocumentNumber($documentNumber)
    {
        $this->documentNumber = $documentNumber;
    }

    /**
     * @return string
     */
    public function getStatAccountNumber()
    {
        return $this->statAccountNumber;
    }

    /**
     * @param string $statAccountNumber
     */
    public function setStatAccountNumber($statAccountNumber)
    {
        $this->statAccountNumber = $statAccountNumber;
    }

    /**
     * @return float|int|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|int|string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getAllocationId()
    {
        return $this->allocationId;
    }

    /**
     * @param string $allocationId
     */
    public function setAllocationId($allocationId)
    {
        $this->allocationId = $allocationId;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
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
     * @return array
     */
    public function getCustomAllocationSplits()
    {
        return $this->customAllocationSplits;
    }

    /**
     * @param array $customAllocationSplits
     */
    public function setCustomAllocationSplits($customAllocationSplits)
    {
        $this->customAllocationSplits = $customAllocationSplits;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $document_number
     *      @var string $stat_account_no
     *      @var float|string|int $amount
     *      @var string $allocation_id
     *      @var array $custom_allocation_splits
     *      @var string $memo
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
     *      @var array $custom_fields
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'document_number' => null,
            'stat_account_no' => null,
            'amount' => null,
            'allocation_id' => null,
            'custom_allocation_splits' => [],
            'memo' => null,
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
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setDocumentNumber($config['document_number']);
        $this->setStatAccountNumber($config['stat_account_no']);
        $this->setAmount($config['amount']);
        $this->setAllocationId($config['allocation_id']);
        $this->setCustomAllocationSplits($config['custom_allocation_splits']);
        $this->setMemo($config['memo']);
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
        $this->setCustomFields($config['custom_fields']);
    }

    /**
     * Write the glentry block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('GLENTRY');

        $xml->writeElement('DOCUMENT', $this->getDocumentNumber());
        $xml->writeElement('ACCOUNTNO', $this->getStatAccountNumber(), true);
        if ($this->getAmount() < 0) {
            $xml->writeElement('TRTYPE', '-1'); //Decrease
            $xml->writeElement('AMOUNT', abs($this->getAmount()), true);
        } else {
            $xml->writeElement('TRTYPE', '1'); //Increase
            $xml->writeElement('AMOUNT', $this->getAmount(), true);
        }

        if ($this->getAllocationId()) {
            $xml->writeElement('ALLOCATION', $this->getAllocationId());

            if ($this->getAllocationId() == static::CUSTOM_ALLOCATION_ID) {
                foreach ($this->getCustomAllocationSplits() as $split) {
                    if ($split instanceof CustomAllocationSplit) {
                        $split->writeXml($xml);
                    } elseif (is_array($split)) {
                        $split = new CustomAllocationSplit($split);

                        $split->writeXml($xml);
                    }
                }
            }
        } else {
            $xml->writeElement('LOCATION', $this->getLocationId());
            $xml->writeElement('DEPARTMENT', $this->getDepartmentId());
            $xml->writeElement('PROJECTID', $this->getProjectId());
            $xml->writeElement('CUSTOMERID', $this->getCustomerId());
            $xml->writeElement('VENDORID', $this->getVendorId());
            $xml->writeElement('EMPLOYEEID', $this->getEmployeeId());
            $xml->writeElement('ITEMID', $this->getItemId());
            $xml->writeElement('CLASSID', $this->getClassId());
            $xml->writeElement('CONTRACTID', $this->getContractId());
            $xml->writeElement('WAREHOUSEID', $this->getWarehouseId());
        }
        $xml->writeElement('DESCRIPTION', $this->getMemo());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //GLENTRY
    }
}
