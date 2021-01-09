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

use Intacct\Xml\XMLWriter;

/**
 * Create a new statistical journal entry line record
 */
class StatisticalJournalEntryLineCreate extends AbstractStatisticalJournalEntryLine
{

    /**
     * Write the GLENTRY block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('GLENTRY');

        $xml->writeElement('DOCUMENT', $this->getDocumentNumber());
        $xml->writeElement('ACCOUNTNO', $this->getStatAccountNumber(), true);
        if ($this->getAmount() < 0) {
            $xml->writeElement('TR_TYPE', '-1'); //Decrease
            $xml->writeElement('TRX_AMOUNT', abs($this->getAmount()), true);
        } else {
            $xml->writeElement('TR_TYPE', '1'); //Increase
            $xml->writeElement('TRX_AMOUNT', $this->getAmount(), true);
        }

        if ($this->getAllocationId()) {
            $xml->writeElement('ALLOCATION', $this->getAllocationId());

            if ($this->getAllocationId() == static::CUSTOM_ALLOCATION_ID) {
                foreach ($this->getCustomAllocationSplits() as $split) {
                    $split->writeXml($xml);
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
