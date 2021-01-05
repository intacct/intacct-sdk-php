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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Xml\XMLWriter;

/**
 * Create a new employee expense report line record
 */
class ExpenseReportLineCreate extends AbstractExpenseReportLine
{

    /**
     * Write the expense block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('expense');

        if (!empty($this->getExpenseType())) {
            $xml->writeElement('expensetype', $this->getExpenseType(), true);
        } else {
            $xml->writeElement('glaccountno', $this->getGlAccountNumber(), true);
        }

        $xml->writeElement('amount', $this->getReimbursementAmount());
        $xml->writeElement('currency', $this->getTransactionCurrency());
        $xml->writeElement('trx_amount', $this->getTransactionAmount());

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
        $xml->writeElement('form1099type', $this->getForm1099type());
        $xml->writeElement('form1099box', $this->getForm1099box());
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
