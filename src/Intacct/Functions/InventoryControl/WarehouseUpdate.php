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

namespace Intacct\Functions\InventoryControl;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Update an existing warehouse record
 */
class WarehouseUpdate extends AbstractWarehouse
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('update');
        $xml->startElement('WAREHOUSE');

        if (!$this->getWarehouseId()) {
            throw new InvalidArgumentException('Warehouse ID is required for update');
        }
        $xml->writeElement('WAREHOUSEID', $this->getWarehouseId(), true);

        $xml->writeElement('NAME', $this->getWarehouseName());
        if ($this->getLocationId()) {
            $xml->startElement('LOC');
            $xml->writeElement('LOCATIONID', $this->getLocationId());
            $xml->endElement(); //LOC
        }
        $xml->writeElement('MANAGERID', $this->getManagerEmployeeId());
        $xml->writeElement('PARENTID', $this->getParentWarehouseId());

        if ($this->getWarehouseContactName()) {
            $xml->startElement('CONTACTINFO');
            $xml->writeElement('CONTACTNAME', $this->getWarehouseContactName());
            $xml->endElement();
        }

        if ($this->getShipToContactName()) {
            $xml->startElement('SHIPTO');
            $xml->writeElement('CONTACTNAME', $this->getShipToContactName());
            $xml->endElement();
        }

        $xml->writeElement('USEDINGL', $this->isUsedInGeneralLedger());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //WAREHOUSE
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
