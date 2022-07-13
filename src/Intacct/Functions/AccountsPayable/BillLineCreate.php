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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Xml\XMLWriter;

/**
 * Create a new accounts payable bill line record
 */
class BillLineCreate extends AbstractBillLine
{

    /**
     * Write the lineitem block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('lineitem');

        if (!empty($this->getAccountLabel())) {
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
        $xml->writeElement('item1099', $this->isForm1099());
        $xml->writeElement('form1099type', $this->getForm1099type());
        $xml->writeElement('form1099box', $this->getForm1099box());
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
        $xml->writeElement('billable', $this->isBillable());

        // if there are tax entries, lets add them to our xml
        if(!empty($this->getTaxEntry())) {
            $xml->startElement('taxentries');
            foreach ($this->getTaxEntry() as $taxentry) {
                $taxentry->writeXml($xml);
            }
            $xml->endElement(); //taxentries
        }

        $xml->endElement(); //lineitem
    }
}
