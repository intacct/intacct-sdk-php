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

use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractCreateTransactionEntry
{

    use CustomFieldsTrait;

    /** @var string */
    protected $itemId;

    /** @var string */
    protected $itemDescription;

    /** @var string */
    protected $warehouseId;

    /** @var string */
    protected $quantity;

    /** @var string */
    protected $unit;

    /** @var array */
    protected $itemDetails;

    /** @var string */
    protected $departmentId;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $projectId;

    /** @var string */
    protected $customerId;

    /** @var string */
    protected $vendorId;

    /** @var string */
    protected $employeeId;

    /** @var string */
    protected $classId;

    /** @var string */
    protected $contractId;

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
            'item_id' => null,
            'item_description' => null,
            'warehouse_id' => null,
            'quantity' => null,
            'unit' => null,
            'item_details' => [],
            'custom_fields' => [],
            'location_id' => null,
            'department_id' => null,
            'project_id' => null,
            'customer_id' => null,
            'vendor_id' => null,
            'employee_id' => null,
            'class_id' => null,
            'contract_id' => null,
        ];
        $config = array_merge($defaults, $params);

        $this->itemId = $config['item_id'];
        $this->itemDescription = $config['item_description'];
        $this->warehouseId = $config['warehouse_id'];
        $this->quantity = $config['quantity'];
        $this->unit = $config['unit'];
        $this->itemDetails = $config['item_details'];
        $this->setCustomFields($config['custom_fields']);
        $this->locationId = $config['location_id'];
        $this->departmentId = $config['department_id'];
        $this->projectId = $config['project_id'];
        $this->customerId = $config['customer_id'];
        $this->vendorId = $config['vendor_id'];
        $this->employeeId = $config['employee_id'];
        $this->classId = $config['class_id'];
        $this->contractId = $config['contract_id'];
    }

    /**
     * @param XMLWriter $xml
     */
    protected function writeXmlItemDetails(XMLWriter &$xml)
    {
        if (count($this->itemDetails) > 0) {
            $xml->startElement('itemdetails');
            foreach ($this->itemDetails as $itemDetail) {
                if ($itemDetail instanceof CreateItemDetail) {
                    $itemDetail->writeXml($xml);
                } elseif (is_array($itemDetail)) {
                    $itemDetail = new CreateItemDetail($itemDetail);

                    $itemDetail->writeXml($xml);
                }
            }
            $xml->endElement(); //itemdetails
        }
    }

    abstract public function writeXml(XMLWriter &$xml);

}