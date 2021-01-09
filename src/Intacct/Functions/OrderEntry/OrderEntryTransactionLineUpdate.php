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

namespace Intacct\Functions\OrderEntry;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Update an existing order entry transaction line record
 */
class OrderEntryTransactionLineUpdate extends AbstractOrderEntryTransactionLine
{

    /** @var int|string */
    private $lineNo;

    /**
     * @return int|string
     */
    public function getLineNo()
    {
        return $this->lineNo;
    }

    /**
     * @param int|string $lineNo
     */
    public function setLineNo($lineNo)
    {
        if ($lineNo < 1) {
            throw new InvalidArgumentException('Line No must be greater than zero');
        }
        $this->lineNo = $lineNo;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('updatesotransitem');
        $xml->writeAttribute('line_num', $this->getLineNo());

        $xml->writeElement('bundlenumber', $this->getBundleNumber());
        $xml->writeElement('itemid', $this->getItemId(), true);
        $xml->writeElement('itemdesc', $this->getItemDescription());
        $xml->writeElement('taxable', $this->isTaxable());
        $xml->writeElement('warehouseid', $this->getWarehouseId());
        $xml->writeElement('quantity', $this->getQuantity(), true);
        $xml->writeElement('unit', $this->getUnit());
        $xml->writeElement('discountpercent', $this->getDiscountPercent());
        $xml->writeElement('price', $this->getPrice());
        $xml->writeElement('discsurchargememo', $this->getDiscountSurchargeMemo());
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

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('revrectemplate', $this->getRevRecTemplate());

        if ($this->getRevRecStartDate()) {
            $xml->startElement('revrecstartdate');
            $xml->writeDateSplitElements($this->getRevRecStartDate(), true);
            $xml->endElement(); //revrecstartdate
        }

        if ($this->getRevRecEndDate()) {
            $xml->startElement('revrecenddate');
            $xml->writeDateSplitElements($this->getRevRecEndDate(), true);
            $xml->endElement(); //revrecenddate
        }

        $xml->writeElement('renewalmacro', $this->getRenewalMacro());
        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('fulfillmentstatus', $this->getFulfillmentStatus());
        $xml->writeElement('taskno', $this->getTaskNumber());
        $xml->writeElement('billingtemplate', $this->getBillingTemplate());

        $xml->endElement(); //updatesotransitem
    }
}
