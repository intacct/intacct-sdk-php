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

namespace Intacct\Functions\SupplyChainManagement;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;

class CreateOrderEntryTransactionEntry extends AbstractCreateOePoTransactionEntry
{

    /** @var string */
    private $bundleNumber;

    /** @var string */
    private $discountPercent;

    /** @var string */
    private $discountSurchargeMemo;

    /** @var string */
    private $revRecTemplate;

    /** @var Date */
    private $revRecStartDate;

    /** @var Date */
    private $revRecEndDate;

    /** @var string */
    private $renewalMacro;

    /** @var string */
    private $fulfillmentStatus;

    /** @var string */
    private $taskNumber;

    /** @var string */
    private $billingTemplate;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'bundle_number' => null,
            'discount_percent' => null,
            'discount_surcharge_memo' => null,
            'rev_rec_template' => null,
            'rev_rec_start_date' => null,
            'rev_rec_end_date' => null,
            'renewal_macro' => null,
            'fulfillment_status' => null,
            'task_number' => null,
            'billing_template' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->bundleNumber = $config['bundle_number'];
        $this->discountPercent = $config['discount_percent'];
        $this->discountSurchargeMemo = $config['discount_surcharge_memo'];
        $this->revRecTemplate = $config['rev_rec_template'];
        $this->revRecStartDate = $config['rev_rec_start_date'];
        $this->revRecEndDate = $config['rev_rec_end_date'];
        $this->renewalMacro = $config['renewal_macro'];
        $this->fulfillmentStatus = $config['fulfillment_status'];
        $this->taskNumber = $config['task_number'];
        $this->billingTemplate = $config['billing_template'];
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('sotransitem');

        $xml->writeElement('bundlenumber', $this->bundleNumber);
        $xml->writeElement('itemid', $this->itemId, true);
        $xml->writeElement('itemdesc', $this->itemDescription);
        $xml->writeElement('taxable', $this->taxable);
        $xml->writeElement('warehouseid', $this->warehouseId);
        $xml->writeElement('quantity', $this->quantity, true);
        $xml->writeElement('unit', $this->unit);
        $xml->writeElement('discountpercent', $this->discountPercent);
        $xml->writeElement('price', $this->price);
        $xml->writeElement('discsurchargememo', $this->discountSurchargeMemo);
        $xml->writeElement('locationid', $this->locationId);
        $xml->writeElement('departmentid', $this->departmentId);
        $xml->writeElement('memo', $this->memo);

        $this->writeXmlItemDetails($xml);

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('revrectemplate', $this->revRecTemplate);

        if ($this->revRecStartDate) {
            $xml->startElement('revrecstartdate');
            $xml->writeDateSplitElements($this->revRecStartDate, true);
            $xml->endElement(); //revrecstartdate
        }

        if ($this->revRecEndDate) {
            $xml->startElement('revrecenddate');
            $xml->writeDateSplitElements($this->revRecEndDate, true);
            $xml->endElement(); //revrecenddate
        }

        $xml->writeElement('renewalmacro', $this->renewalMacro);
        $xml->writeElement('projectid', $this->projectId);
        $xml->writeElement('customerid', $this->customerId);
        $xml->writeElement('vendorid', $this->vendorId);
        $xml->writeElement('employeeid', $this->employeeId);
        $xml->writeElement('classid', $this->classId);
        $xml->writeElement('contractid', $this->contractId);
        $xml->writeElement('fulfillmentstatus', $this->fulfillmentStatus);
        $xml->writeElement('taskno', $this->taskNumber);
        $xml->writeElement('billingtemplate', $this->billingTemplate);

        $xml->endElement(); //sotransitem
    }
}
