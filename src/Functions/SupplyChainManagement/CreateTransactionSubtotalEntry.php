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

class CreateTransactionSubtotalEntry
{

    use CustomFieldsTrait;

    /** @var string */
    private $description;

    /** @var string */
    private $total;

    /** @var string */
    private $absoluteValue;

    /** @var string */
    private $percentageValue;

    /** @var string */
    private $departmentId;

    /** @var string */
    private $locationId;

    /** @var string */
    private $projectId;

    /** @var string */
    private $customerId;

    /** @var string */
    private $vendorId;

    /** @var string */
    private $employeeId;

    /** @var string */
    private $itemId;

    /** @var string */
    private $classId;

    /** @var string */
    private $contractId;

    //private $warehouseId;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var float|string $absolute_value
     *      @var string $class_id
     *      @var string $contract_id
     *      @var array $custom_fields
     *      @var string $customer_id
     *      @var string $department_id
     *      @var string $description
     *      @var string $employee_id
     *      @var string $item_id
     *      @var string $location_id
     *      @var float|string $percentage_value
     *      @var string $project_id
     *      @var float|string $total
     *      @var string $vendor_id
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'description' => null,
            'total' => null,
            'absolute_value' => null,
            'percentage_value' => null,
            'location_id' => null,
            'department_id' => null,
            'project_id' => null,
            'customer_id' => null,
            'vendor_id' => null,
            'employee_id' => null,
            'class_id' => null,
            'item_id' => null,
            'contract_id' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        $this->description = $config['description'];
        $this->total = $config['total'];
        $this->absoluteValue = $config['absolute_value'];
        $this->percentageValue = $config['percentage_value'];
        $this->departmentId = $config['department_id'];
        $this->locationId = $config['location_id'];
        $this->projectId = $config['project_id'];
        $this->customerId = $config['customer_id'];
        $this->vendorId = $config['vendor_id'];
        $this->employeeId = $config['employee_id'];
        $this->itemId = $config['item_id'];
        $this->classId = $config['class_id'];
        $this->contractId = $config['contract_id'];
        //TODO $this->warehouseId = $config['warehouse_id'];

        $this->setCustomFields($config['custom_fields']);
    }

    /**
     * Write the subtotal block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('subtotal');

        $xml->writeElement('description', $this->description, true);
        $xml->writeElement('total', $this->total, true);
        $xml->writeElement('absval', $this->absoluteValue);
        $xml->writeElement('percentval', $this->percentageValue);
        $xml->writeElement('locationid', $this->locationId);
        $xml->writeElement('departmentid', $this->departmentId);
        $xml->writeElement('projectid', $this->projectId);
        $xml->writeElement('customerid', $this->customerId);
        $xml->writeElement('vendorid', $this->vendorId);
        $xml->writeElement('employeeid', $this->employeeId);
        $xml->writeElement('classid', $this->classId);
        $xml->writeElement('itemid', $this->itemId);
        $xml->writeElement('contractid', $this->contractId);
        $this->writeXmlExplicitCustomFields($xml);

        $xml->endElement(); //subtotal
    }
}
