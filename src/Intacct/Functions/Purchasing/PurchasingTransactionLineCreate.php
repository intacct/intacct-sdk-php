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

namespace Intacct\Functions\Purchasing;

use Intacct\Xml\XMLWriter;

/**
 * Create a new purchasing transaction line record
 */
class PurchasingTransactionLineCreate extends AbstractPurchasingTransactionLine
{

    /**
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('potransitem');

        $xml->writeElement('itemid', $this->getItemId(), true);
        $xml->writeElement('itemdesc', $this->getItemDescription());
        $xml->writeElement('taxable', $this->isTaxable());
        $xml->writeElement('warehouseid', $this->getWarehouseId());
        $xml->writeElement('quantity', $this->getQuantity(), true);
        $xml->writeElement('unit', $this->getUnit());
        $xml->writeElement('price', $this->getPrice());
        $xml->writeElement('overridetaxamount', $this->getOverrideTaxAmount());
        $xml->writeElement('tax', $this->getTax());
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('memo', $this->getMemo());

        if (count($this->getItemDetails()) > 0) {
            $xml->startElement('itemdetails');
            foreach ($this->getItemDetails() as $itemDetail) {
                $itemDetail->writeXml($xml);
            }
            $xml->endElement(); //itemdetails
        }

        $xml->writeElement('form1099', $this->isForm1099());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('billable', $this->isBillable());

        $xml->endElement(); //potransitem
    }
}
