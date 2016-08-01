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

use Intacct\Xml\XMLWriter;

class CreatePurchasingTransactionEntry extends AbstractCreateOePoTransactionEntry
{

    /** @var string */
    private $overrideTaxAmount;

    /** @var string */
    private $tax;

    /** @var bool */
    private $form1099;

    /** @var bool */
    private $billable;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $item_id
     *      @var string $item_description
     *      @var bool $taxable
     *      @var string $warehouse_id
     *      @var int|string|float $quantity
     *      @var string $unit
     *      @var float|string $price
     *      @var float|string $override_tax_amount
     *      @var float|string $tax
     *      @var string $location_id
     *      @var string $department_id
     *      @var string $memo
     *      @var array $item_details
     *      @var bool $form1099
     *      @var array $custom_fields
     *      @var string $project_id
     *      @var string $customer_id
     *      @var string $vendor_id
     *      @var string $employee_id
     *      @var string $class_id
     *      @var string $contract_id
     *      @var bool $billable
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'override_tax_amount' => null,
            'tax' => null,
            'form1099' => null,
            'billable' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->overrideTaxAmount = $config['override_tax_amount'];
        $this->tax = $config['tax'];
        $this->form1099 = $config['form1099'];
        $this->billable = $config['billable'];
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('potransitem');

        $xml->writeElement('itemid', $this->itemId, true);
        $xml->writeElement('itemdesc', $this->itemDescription);
        $xml->writeElement('taxable', $this->taxable);
        $xml->writeElement('warehouseid', $this->warehouseId);
        $xml->writeElement('quantity', $this->quantity, true);
        $xml->writeElement('unit', $this->unit);
        $xml->writeElement('price', $this->price);
        $xml->writeElement('overridetaxamount', $this->overrideTaxAmount);
        $xml->writeElement('tax', $this->tax);
        $xml->writeElement('locationid', $this->locationId);
        $xml->writeElement('departmentid', $this->departmentId);
        $xml->writeElement('memo', $this->memo);

        $this->writeXmlItemDetails($xml);

        $xml->writeElement('form1099', $this->form1099);

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('projectid', $this->projectId);
        $xml->writeElement('customerid', $this->customerId);
        $xml->writeElement('vendorid', $this->vendorId);
        $xml->writeElement('employeeid', $this->employeeId);
        $xml->writeElement('classid', $this->classId);
        $xml->writeElement('contractid', $this->contractId);
        $xml->writeElement('billable', $this->billable);

        $xml->endElement(); //potransitem
    }
}
