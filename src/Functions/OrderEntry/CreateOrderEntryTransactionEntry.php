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

namespace Intacct\Functions\OrderEntry;

use Intacct\Fields\Date;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DimensionsTrait;
use Intacct\Xml\XMLWriter;

class CreateOrderEntryTransactionEntry
{
    use DimensionsTrait;
    use CustomFieldsTrait;

    /**
     * @var string
     */
    private $bundleNumber;

    /**
     * @var string
     */
    private $itemDescription;

    /**
     * @var bool
     */
    private $taxable;

    /**
     * @var string
     */
    private $quantity;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var string
     */
    private $discountPercent;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $discountSurchargeMemo;

    /**
     * @var string
     */
    private $memo;

    /**
     * @var array
     */
    private $itemDetails;

    /**
     * @var string
     */
    private $revRecTemplate;

    /**
     * @var Date
     */
    private $revRecStartDate;

    /**
     * @var Date
     */
    private $revRecEndDate;

    /**
     * @var string
     */
    private $renewalMacro;

    /**
     * @var string
     */
    private $fulfillmentStatus;

    /**
     * @var string
     */
    private $taskNumber;

    /**
     * @var string
     */
    private $billingTemplate;

    /**
     * CreateOrderEntryTransactionEntry constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'bundle_number' => null,
            'item_id' => null,
            'item_description' => null,
            'taxable' => null,
            'warehouse_id' => null,
            'quantity' => null,
            'unit' => null,
            'discount_percent' => null,
            'price' => null,
            'discount_surcharge_memo' => null,  //name ??
            'location_id' => null,
            'department_id' => null,
            'memo' => null,
            'item_details' => [],
            'custom_fields' => [],
            'rev_rec_template' => null,
            'rev_rec_start_date' => null,
            'rev_rec_end_date' => null,
            'renewal_macro' => null, // Quarterly
            'project_id' => null,
            'customer_id' => null,
            'vendor_id' => null,
            'employee_id' => null,
            'class_id' => null,
            'contract_id' => null,
            'fulfillment_status' => null,
            'task_number' => null,
            'billing_template' => null,
        ];
        $config = array_merge($defaults, $params);

        $this->bundleNumber = $config['bundle_number'];
        $this->setItemId($config['item_id']);
        $this->itemDescription = $config['item_description'];
        $this->taxable = $config['taxable'];
        $this->setWarehouseId($config['warehouse_id']);
        $this->quantity = $config['quantity'];
        $this->unit = $config['unit'];
        $this->discountPercent = $config['discount_percent'];
        $this->price = $config['price'];
        $this->discountSurchargeMemo = $config['discount_surcharge_memo'];
        $this->setLocationId($config['location_id']);
        $this->setDepartmentId($config['department_id']);
        $this->memo = $config['memo'];
        $this->itemDetails = $config['item_details'];
        $this->setCustomFields($config['custom_fields']);
        $this->revRecTemplate = $config['rev_rec_template'];
        $this->setRevRecStartDate($config['rev_rec_start_date']);
        $this->setRevRecEndDate($config['rev_rec_end_date']);
        $this->renewalMacro = $config['renewal_macro'];
        $this->setProjectId($config['project_id']);
        $this->setCustomerId($config['customer_id']);
        $this->setVendorId($config['vendor_id']);
        $this->setEmployeeId($config['employee_id']);
        $this->setClassId($config['class_id']);
        $this->setContractId($config['contract_id']);
        $this->fulfillmentStatus = $config['fulfillment_status'];
        $this->taskNumber = $config['task_number'];
        $this->billingTemplate = $config['billing_template'];
    }

    /**
     * @param string|Date $revRecStartDate
     */
    private function setRevRecStartDate($revRecStartDate)
    {
        if (is_null($revRecStartDate) || $revRecStartDate instanceof Date) {
            $this->revRecStartDate = $revRecStartDate;
        } else {
            $this->revRecStartDate = new Date($revRecStartDate);
        }
    }

    /**
     * @param string|Date $revRecEndDate
     */
    private function setRevRecEndDate($revRecEndDate)
    {
        if (is_null($revRecEndDate) || $revRecEndDate instanceof Date) {
            $this->revRecEndDate = $revRecEndDate;
        } else {
            $this->revRecEndDate = new Date($revRecEndDate);
        }
    }

    /**
     * @param XMLWriter $xml
     */
    private function getItemDetails(XMLWriter &$xml)
    {
        if (count($this->itemDetails) > 0) {
            $xml->startElement('itemdetails');

            foreach ($this->itemDetails as $itemDetail) {
                if ($itemDetail instanceof CreateItemDetail) {
                    $itemDetail->getXml($xml);
                } elseif (is_array($itemDetail)) {
                    $itemDetail = new CreateItemDetail($itemDetail);

                    $itemDetail->getXml($xml);
                }
            }
            $xml->endElement(); //itemdetails
        }
    }

    /**
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('sotransitem');

        $xml->writeElement('bundlenumber', $this->bundleNumber);
        $xml->writeElement('itemid', $this->getItemId(), true);
        $xml->writeElement('itemdesc', $this->itemDescription);
        $xml->writeElement('taxable', $this->taxable);
        $xml->writeElement('warehouseid', $this->getWarehouseId());
        $xml->writeElement('quantity', $this->quantity, true);
        $xml->writeElement('unit', $this->unit);
        $xml->writeElement('discountpercent', $this->discountPercent);
        $xml->writeElement('price', $this->price);
        $xml->writeElement('discsurchargememo', $this->discountSurchargeMemo);
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('memo', $this->memo);

        $this->getItemDetails($xml);

        $this->getCustomFieldsXml($xml);

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
        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('fulfillmentstatus', $this->fulfillmentStatus);
        $xml->writeElement('taskno', $this->taskNumber);
        $xml->writeElement('billingtemplate', $this->billingTemplate);

        $xml->endElement(); //sotransitem
    }
}
