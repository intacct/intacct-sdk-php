<?php
/**
 *
 * *
 *  * Copyright 2016 Intacct Corporation.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  * use this file except in compliance with the License. You may obtain a copy
 *  * of the License at
 *  *
 *  * http://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * or in the "LICENSE" file accompanying this file. This file is distributed on
 *  * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 *  * express or implied. See the License for the specific language governing
 *  * permissions and limitations under the License.
 *
 *
 */

namespace Intacct\Functions\Purchasing;

use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DimensionsTrait;
use Intacct\Xml\XMLWriter;
use Intacct\Functions\CreateItemDetail;

class CreatePurchasingTransactionEntry
{

    use DimensionsTrait;
    use CustomFieldsTrait;

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
    private $price;

    /**
     * @var string
     */
    private $overrideTaxAmount;

    /**
     * @var string
     */
    private $tax;

    /**
     * @var string
     */
    private $memo;

    /**
     * @var array
     */
    private $itemDetails;

    /**
     * @var bool
     */
    private $form1099;

    /**
     * @var bool
     */
    private $billable;

    /**
     * CreateOrderEntryTransactionEntry constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'item_id' => null,
            'item_description' => null,
            'taxable' => null,
            'warehouse_id' => null,
            'quantity' => null,
            'unit' => null,
            'price' => null,
            'override_tax_amount' => null,
            'tax' => null,
            'location_id' => null,
            'department_id' => null,
            'memo' => null,
            'item_details' => [],
            'form1099' => null,
            'custom_fields' => [],
            'project_id' => null,
            'customer_id' => null,
            'vendor_id' => null,
            'employee_id' => null,
            'class_id' => null,
            'contract_id' => null,
            'billable' => null,
        ];
        $config = array_merge($defaults, $params);

        $this->setItemId($config['item_id']);
        $this->itemDescription = $config['item_description'];
        $this->taxable = $config['taxable'];
        $this->setWarehouseId($config['warehouse_id']);
        $this->quantity = $config['quantity'];
        $this->unit = $config['unit'];
        $this->price = $config['price'];
        $this->overrideTaxAmount = $config['override_tax_amount'];
        $this->tax = $config['tax'];
        $this->setLocationId($config['location_id']);
        $this->setDepartmentId($config['department_id']);
        $this->memo = $config['memo'];
        $this->form1099 = $config['form1099'];
        $this->itemDetails = $config['item_details'];
        $this->setCustomFields($config['custom_fields']);
        $this->setProjectId($config['project_id']);
        $this->setCustomerId($config['customer_id']);
        $this->setVendorId($config['vendor_id']);
        $this->setEmployeeId($config['employee_id']);
        $this->setClassId($config['class_id']);
        $this->setContractId($config['contract_id']);
        $this->billable = $config['billable'];
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
                } else if (is_array($itemDetail)) {
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
        $xml->startElement('potransitem');

        $xml->writeElement('itemid', $this->getItemId(), true);
        $xml->writeElement('itemdesc', $this->itemDescription);
        $xml->writeElement('taxable', $this->taxable);
        $xml->writeElement('warehouseid', $this->getWarehouseId());
        $xml->writeElement('quantity', $this->quantity, true);
        $xml->writeElement('unit', $this->unit);
        $xml->writeElement('price', $this->price);
        $xml->writeElement('overridetaxamount', $this->overrideTaxAmount);
        $xml->writeElement('tax', $this->tax);
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('memo', $this->memo);

        $this->getItemDetails($xml);

        $xml->writeElement('form1099', $this->form1099);

        $this->getCustomFieldsXml($xml);

        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('billable' , $this->billable);

        $xml->endElement(); //potransitem
    }
}