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

namespace Intacct\Functions\CashManagement;

use Intacct\Xml\XMLWriter;

/**
 * Create a new cash management charge card transaction line record
 */
class ChargeCardTransactionLineCreate extends AbstractChargeCardTransactionLine
{

    /**
     * Write the ccpayitem block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('ccpayitem');

        if (!empty($this->getAccountLabel())) {
            $xml->writeElement('accountlabel', $this->getAccountLabel(), true);
        } else {
            $xml->writeElement('glaccountno', $this->getGlAccountNumber(), true);
        }

        $xml->writeElement('description', $this->getMemo());
        $xml->writeElement('paymentamount', $this->getTransactionAmount(), true);
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('itemid', $this->getItemId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('warehouseid', $this->getWarehouseId());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->endElement(); //ccpayitem
    }
}
