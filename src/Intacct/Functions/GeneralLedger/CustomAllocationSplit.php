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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Functions\Company\AbstractAllocationLine;
use Intacct\Xml\XMLWriter;

/**
 * Create a new custom allocation split record
 */
class CustomAllocationSplit extends AbstractAllocationLine
{

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
