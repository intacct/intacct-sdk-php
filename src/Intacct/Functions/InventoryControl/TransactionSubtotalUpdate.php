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

use Intacct\Xml\XMLWriter;

/**
 * Create a new transaction subtotal record
 */
class TransactionSubtotalUpdate extends AbstractTransactionSubtotal
{

    /**
     * Write the subtotal block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('updatesubtotal');

        $xml->writeElement('description', $this->getDescription(), true);
        $xml->writeElement('total', $this->getTotal(), true);
        $xml->writeElement('absval', $this->getAbsoluteValue());
        $xml->writeElement('percentval', $this->getPercentageValue());
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('itemid', $this->getItemId());
        $xml->writeElement('contractid', $this->getContractId());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->endElement(); //updatesubtotal
    }
}
