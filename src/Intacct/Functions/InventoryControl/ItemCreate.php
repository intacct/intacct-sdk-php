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
 * Create a new item record
 */
class ItemCreate extends AbstractItem
{

    /** @var string */
    protected $itemType;

    /**
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @param string $itemType
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
    }

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

        $xml->startElement('create');
        $xml->startElement('ITEM');

        if (!$this->getItemId()) {
            throw new InvalidArgumentException('Item ID is required for create');
        }
        $xml->writeElement('ITEMID', $this->getItemId(), true);

        if (!$this->getItemName()) {
            throw new InvalidArgumentException('Item Name is required for create');
        }
        $xml->writeElement('NAME', $this->getItemName(), true);

        if (!$this->getItemType()) {
            throw new InvalidArgumentException('Item Type is required for create');
        }
        $xml->writeElement('ITEMTYPE', $this->getItemType(), true);

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $xml->writeElement('PRODUCTLINEID', $this->getProduceLineId());
        $xml->writeElement('COST_METHOD', $this->getCostMethod());
        $xml->writeElement('EXTENDED_DESCRIPTION', $this->getExtendedDescription());
        $xml->writeElement('PODESCRIPTION', $this->getPurchasingDescription());
        $xml->writeElement('SODESCRIPTION', $this->getSalesDescription());
        $xml->writeElement('UOMGRP', $this->getUnitOfMeasure());
        $xml->writeElement('NOTE', $this->getNote());
        $xml->writeElement('SHIP_WEIGHT', $this->getShippingWeight());
        $xml->writeElement('GLGROUP', $this->getItemGlGroupName());
        $xml->writeElement('STANDARD_COST', $this->getStandardCost());
        $xml->writeElement('BASEPRICE', $this->getBasePrice());
        $xml->writeElement('TAXABLE', $this->isTaxable());
        $xml->writeElement('TAXGROUP', $this->getItemTaxGroupName());
        $xml->writeElement('DEFAULTREVRECTEMPLKEY', $this->getDefaultRevRecTemplateId());
        $xml->writeElement('INCOMEACCTKEY', $this->getRevenueGlAccountNo());
        $xml->writeElement('INVACCTKEY', $this->getInventoryGlAccountNo());
        $xml->writeElement('EXPENSEACCTKEY', $this->getExpenseGlAccountNo());
        $xml->writeElement('COGSACCTKEY', $this->getCogsGlAccountNo());
        $xml->writeElement('OFFSETOEGLACCOUNTKEY', $this->getArGlAccountNo());
        $xml->writeElement('OFFSETPOGLACCOUNTKEY', $this->getApGlAccountNo());
        $xml->writeElement('DEFERREDREVACCTKEY', $this->getDeferredRevGlAccountNo());
        $xml->writeElement('VSOECATEGORY', $this->getVsoeCategory());
        $xml->writeElement('VSOEDLVRSTATUS', $this->getVsoeDefaultDeliveryStatus());
        $xml->writeElement('VSOEREVDEFSTATUS', $this->getVsoeDefaultDeferralStatus());
        $xml->writeElement('REVPOSTING', $this->getKitRevenuePosting());
        $xml->writeElement('REVPRINTING', $this->getKitPrintFormat());
        $xml->writeElement('SUBSTITUTEID', $this->getSubstituteItemId());
        $xml->writeElement('ENABLE_SERIALNO', $this->isSerialTrackingEnabled());
        $xml->writeElement('SERIAL_MASKKEY', $this->getSerialNumberMask());
        $xml->writeElement('ENABLE_LOT_CATEGORY', $this->isLotTrackingEnabled());
        $xml->writeElement('LOT_CATEGORYKEY', $this->getLotCategory());
        $xml->writeElement('ENABLE_BINS', $this->isBinTrackingEnabled());
        $xml->writeElement('ENABLE_EXPIRATION', $this->isExpTrackingEnabled());
        $xml->writeElement('UPC', $this->getUpc());
        $xml->writeElement('INV_PRECISION', $this->getUnitCostPrecisionInventory());
        $xml->writeElement('SO_PRECISION', $this->getUnitCostPrecisionSales());
        $xml->writeElement('PO_PRECISION', $this->getUnitCostPrecisionPurchasing());
        $xml->writeElement('HASSTARTENDDATES', $this->isItemStartEndDateEnabled());
        $xml->writeElement('TERMPERIOD', $this->getPeriodsMeasuredIn());
        $xml->writeElement('TOTALPERIODS', $this->getNumberOfPeriods());
        $xml->writeElement('COMPUTEFORSHORTTERM', $this->isProratePriceAllowed());
        $xml->writeElement('RENEWALMACROID', $this->getDefaultRenewalMacroId());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //ITEM
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
