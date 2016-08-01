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

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @todo add unit tests
 */
class CreateEeReportEntry extends AbstractEeTransactionEntry
{

    /**
     * @return string
     */
    public function getExpenseType()
    {
        return $this->expenseType;
    }

    /**
     * @param string $expenseType
     */
    public function setExpenseType($expenseType)
    {
        $this->expenseType = $expenseType;
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
     * @return float|string
     */
    public function getReimbursementAmount()
    {
        return $this->reimbursementAmount;
    }

    /**
     * @param float|string $reimbursementAmount
     */
    public function setReimbursementAmount($reimbursementAmount)
    {
        $this->reimbursementAmount = $reimbursementAmount;
    }

    /**
     * @return string
     */
    public function getPaymentTypeName()
    {
        return $this->paymentTypeName;
    }

    /**
     * @param string $paymentTypeName
     */
    public function setPaymentTypeName($paymentTypeName)
    {
        $this->paymentTypeName = $paymentTypeName;
    }

    /**
     * @return boolean
     */
    public function isForm1099()
    {
        return $this->form1099;
    }

    /**
     * @param boolean $form1099
     */
    public function setForm1099($form1099)
    {
        $this->form1099 = $form1099;
    }

    /**
     * @return string
     */
    public function getPaidTo()
    {
        return $this->paidTo;
    }

    /**
     * @param string $paidTo
     */
    public function setPaidTo($paidTo)
    {
        $this->paidTo = $paidTo;
    }

    /**
     * @return string
     */
    public function getPaidFor()
    {
        return $this->paidFor;
    }

    /**
     * @param string $paidFor
     */
    public function setPaidFor($paidFor)
    {
        $this->paidFor = $paidFor;
    }

    /**
     * @return Date
     */
    public function getExpenseDate()
    {
        return $this->expenseDate;
    }

    /**
     * @param Date $expenseDate
     */
    public function setExpenseDate($expenseDate)
    {
        $this->expenseDate = $expenseDate;
    }

    /**
     * @return float|int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float|int|string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float|int|string
     */
    public function getUnitRate()
    {
        return $this->unitRate;
    }

    /**
     * @param float|int|string $unitRate
     */
    public function setUnitRate($unitRate)
    {
        $this->unitRate = $unitRate;
    }

    /**
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
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
     * @return Date
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * @param Date $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        $this->exchangeRateDate = $exchangeRateDate;
    }

    /**
     * @return float
     */
    public function getExchangeRateValue()
    {
        return $this->exchangeRateValue;
    }

    /**
     * @param float $exchangeRateValue
     */
    public function setExchangeRateValue($exchangeRateValue)
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

    /**
     * @return string
     */
    public function getExchangeRateType()
    {
        return $this->exchangeRateType;
    }

    /**
     * @param string $exchangeRateType
     */
    public function setExchangeRateType($exchangeRateType)
    {
        $this->exchangeRateType = $exchangeRateType;
    }

    /**
     * @return boolean
     */
    public function isBillable()
    {
        return $this->billable;
    }

    /**
     * @param boolean $billable
     */
    public function setBillable($billable)
    {
        $this->billable = $billable;
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
     * @todo finish me
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'expense_type' => null,
            'gl_account_no' => null,
            'reimbursement_amount' => null,
            'payment_type_name' => null,
            'form_1099' => null,
            'paid_to' => null,
            'paid_for' => null,
            'expense_date' => null,
            'quantity' => null,
            'unit_rate' => null,
            'transaction_currency' => null,
            'transaction_amount' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'billable' => null,
            'department_id' => null,
            'location_id' => null,
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

        $this->setExpenseType($config['expense_type']);
        $this->setGlAccountNumber($config['gl_account_no']);
        $this->setReimbursementAmount($config['reimbursement_amount']);
        $this->setPaymentTypeName($config['payment_type_name']);
        $this->setForm1099($config['form_1099']);
        $this->setPaidTo($config['paid_to']);
        $this->setPaidFor($config['paid_for']);
        $this->setExpenseDate($config['expense_date']);
        $this->setQuantity($config['quantity']);
        $this->setUnitRate($config['unit_rate']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setTransactionAmount($config['transaction_amount']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->setBillable($config['billable']);
        $this->setDepartmentId($config['department_id']);
        $this->setLocationId($config['location_id']);
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
     * Write the expense block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('expense');

        if (!is_null($this->getExpenseType())) {
            $xml->writeElement('expensetype', $this->getExpenseType(), true);
        } else {
            $xml->writeElement('glaccountno', $this->getGlAccountNumber(), true);
        }

        $xml->writeElement('amount', $this->getReimbursementAmount(), true);
        $xml->writeElement('currency', $this->getTransactionCurrency(), true);
        $xml->writeElement('trx_amount', $this->getTransactionAmount(), true);

        if ($this->getExchangeRateDate()) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->getExchangeRateDate(), true);
            $xml->endElement();
        }

        if ($this->getExchangeRateType()) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType());
        } elseif ($this->getExchangeRateValue()) {
            $xml->writeElement('exchrate', $this->getExchangeRateValue());
        } elseif ($this->getTransactionCurrency() || $this->getTransactionAmount()) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType(), true);
        }

        if ($this->getExpenseDate()) {
            $xml->startElement('expensedate');
            $xml->writeDateSplitElements($this->getExpenseDate(), true);
            $xml->endElement();
        }

        $xml->writeElement('memo', $this->getPaidTo());
        $xml->writeElement('form1099', $this->isForm1099());
        $xml->writeElement('paidfor', $this->getPaidFor());
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('itemid', $this->getItemId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('warehouseid', $this->getWarehouseId());
        $xml->writeElement('billable', $this->isBillable());
        $xml->writeElement('exppmttype', $this->getPaymentTypeName());
        $xml->writeElement('quantity', $this->getQuantity());
        $xml->writeElement('rate', $this->getUnitRate());

        $xml->endElement(); //expense
    }
}
