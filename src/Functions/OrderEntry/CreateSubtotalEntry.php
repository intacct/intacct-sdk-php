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

namespace Intacct\Functions\OrderEntry;


use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DimensionsTrait;
use Intacct\Xml\XMLWriter;

class CreateSubtotalEntry
{

    use DimensionsTrait;
    use CustomFieldsTrait;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $total;

    /**
     * @var string
     */
    private $absoluteValue;

    /**
     * @var string
     */
    private $percentageValue;

    /**
     * CreateSubtotalEntry constructor.
     * @param array $params
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
        $this->setLocationId($config['location_id']);
        $this->setDepartmentId($config['department_id']);
        $this->setProjectId($config['project_id']);
        $this->setCustomerId($config['customer_id']);
        $this->setVendorId($config['vendor_id']);
        $this->setEmployeeId($config['employee_id']);
        $this->setClassId($config['class_id']);
        $this->setItemId($config['item_id']);
        $this->setContractId($config['contract_id']);
        $this->setCustomFields($config['custom_fields']);
    }

    /**
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('subtotal');

        $xml->writeElement('description', $this->description, true);
        $xml->writeElement('total', $this->total, true);
        $xml->writeElement('absval', $this->absoluteValue);
        $xml->writeElement('percentval', $this->percentageValue);
        $xml->writeElement('locationid', $this->locationId);
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('itemid', $this->getItemId());
        $xml->writeElement('contractid', $this->getContractId());
        $this->getCustomFieldsXml($xml);

        $xml->endElement(); //subtotal
    }
}