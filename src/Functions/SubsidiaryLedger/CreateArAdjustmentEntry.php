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

namespace Intacct\Functions\SubsidiaryLedger;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateArAdjustmentEntry extends AbstractTransactionEntry
{

    /**
     * @return string
     */
    public function getAccountLabel()
    {
        return $this->accountLabel;
    }

    /**
     * @param string $accountLabel
     */
    public function setAccountLabel($accountLabel)
    {
        $this->accountLabel = $accountLabel;
    }

    /**
     * @return string
     */
    public function getGlAccountNumber()
    {
        return $this->glAccountNumber;
    }

    /**
     * @param string $glAccountNumber
     */
    public function setGlAccountNumber($glAccountNumber)
    {
        $this->glAccountNumber = $glAccountNumber;
    }

    /**
     * @return string
     */
    public function getOffsetGLAccountNumber()
    {
        return $this->offsetGLAccountNumber;
    }

    /**
     * @param string $offsetGLAccountNumber
     */
    public function setOffsetGLAccountNumber($offsetGLAccountNumber)
    {
        $this->offsetGLAccountNumber = $offsetGLAccountNumber;
    }

    /**
     * @return float|string
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * @param float|string $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->transactionAmount = $transactionAmount;
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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return float|string
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * @param float|string $totalPaid
     */
    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;
    }

    /**
     * @return float|string
     */
    public function getTotalDue()
    {
        return $this->totalDue;
    }

    /**
     * @param float|string $totalDue
     */
    public function setTotalDue($totalDue)
    {
        $this->totalDue = $totalDue;
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
     *      @var string $account_label
     *      @var string $gl_account_no
     *      @var string $offset_gl_account_no
     *      @var float|string $transaction_amount
     *      @var string $allocation_id
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
     *      @var bool $billable
     *      @var bool $form_1099
     *      @var string|int $key
     *      @var float|string $total_paid
     *      @var float|string $total_due
     *      @var array $custom_fields
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'account_label' => null,
            'gl_account_no' => null,
            'offset_gl_account_no' => null,
            'transaction_amount' => null,
            'allocation_id' => null,
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
            'key' => null,
            'total_paid' => null,
            'total_due' => null,
            'custom_fields' => [],
        ];

        $config = array_merge($defaults, $params);

        $this->setAccountLabel($config['account_label']);
        $this->setGlAccountNumber($config['gl_account_no']);
        $this->setOffsetGLAccountNumber($config['offset_gl_account_no']);
        $this->setTransactionAmount($config['transaction_amount']);
        $this->setAllocationId($config['allocation_id']);
        $this->setMemo($config['memo']);
        $this->setLocationId($config['location_id']);
        $this->setDepartmentId($config['department_id']);
        $this->setKey($config['key']);
        $this->setTotalPaid($config['total_paid']);
        $this->setTotalDue($config['total_due']);
        $this->setCustomFields($config['custom_fields']);
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
     * Write the lineitem block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('lineitem');

        if (!is_null($this->getAccountLabel())) {
            $xml->writeElement('accountlabel', $this->getAccountLabel(), true);
        } else {
            $xml->writeElement('glaccountno', $this->getGlAccountNumber(), true);
        }

        $xml->writeElement('offsetglaccountno', $this->getOffsetGLAccountNumber());
        $xml->writeElement('amount', $this->getTransactionAmount(), true);
        $xml->writeElement('allocationid', $this->getAllocationId());
        $xml->writeElement('memo', $this->getMemo());
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('key', $this->getKey());
        $xml->writeElement('totalpaid', $this->getTotalPaid());
        $xml->writeElement('totaldue', $this->getTotalDue());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('itemid', $this->getItemId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('warehouseid', $this->getWarehouseId());

        $xml->endElement(); //lineitem
    }
}
