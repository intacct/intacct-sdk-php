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

namespace Intacct\Functions\Projects;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new project record
 */
class ProjectCreate extends AbstractProject
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

        $xml->startElement('create');
        $xml->startElement('PROJECT');

        // Project ID is not required if auto-numbering is configured in module
        $xml->writeElement('PROJECTID', $this->getProjectId());

        if (!$this->getProjectName()) {
            throw new InvalidArgumentException('Project Name is required for create');
        }
        $xml->writeElement('NAME', $this->getProjectName(), true);

        if (!$this->getProjectCategory()) {
            throw new InvalidArgumentException('Project Category is required for create');
        }
        $xml->writeElement('PROJECTCATEGORY', $this->getProjectCategory(), true);

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('PARENTID', $this->getParentProjectId());
        $xml->writeElement('INVOICEWITHPARENT', $this->isInvoiceWithParent());
        $xml->writeElement('PROJECTTYPE', $this->getProjectType());
        $xml->writeElement('PROJECTSTATUS', $this->getProjectStatus());
        $xml->writeElement('CUSTOMERID', $this->getCustomerId());
        $xml->writeElement('MANAGERID', $this->getProjectManagerEmployeeId());
        $xml->writeElement('CUSTUSERID', $this->getExternalUserId());
        $xml->writeElement('SALESCONTACTID', $this->getSalesContactEmployeeId());
        $xml->writeElement('DOCNUMBER', $this->getReferenceNo());
        $xml->writeElement('USERRESTRICTIONS', $this->getUserRestrictions());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        if ($this->getPrimaryContactName()) {
            $xml->startElement('CONTACTINFO');
            $xml->writeElement('CONTACTNAME', $this->getPrimaryContactName(), true);
            $xml->endElement();
        }

        if ($this->getBillToContactName()) {
            $xml->startElement('BILLTO');
            $xml->writeElement('CONTACTNAME', $this->getBillToContactName(), true);
            $xml->endElement();
        }

        if ($this->getShipToContactName()) {
            $xml->startElement('SHIPTO');
            $xml->writeElement('CONTACTNAME', $this->getShipToContactName(), true);
            $xml->endElement();
        }

        $xml->writeElement('TERMNAME', $this->getPaymentTerms());
        $xml->writeElement('BILLINGTYPE', $this->getBillingType());
        $xml->writeElementDate('BEGINDATE', $this->getBeginDate());
        $xml->writeElementDate('ENDDATE', $this->getEndDate());
        $xml->writeElement('DEPARTMENTID', $this->getDepartmentId());
        $xml->writeElement('LOCATIONID', $this->getLocationId());
        $xml->writeElement('CLASSID', $this->getClassId());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('BILLABLEEXPDEFAULT', $this->isBillableEmployeeExpense());
        $xml->writeElement('BILLABLEAPPODEFAULT', $this->isBillableApPurchasing());
        $xml->writeElement('OBSPERCENTCOMPLETE', $this->getObservedPercentComplete());
        $xml->writeElement('CURRENCY', $this->getCurrency());
        $xml->writeElement('SONUMBER', $this->getSalesOrderNo());
        $xml->writeElement('PONUMBER', $this->getPurchaseOrderNo());
        $xml->writeElement('POAMOUNT', $this->getPurchaseOrderAmount());
        $xml->writeElement('PQNUMBER', $this->getPurchaseQuoteNo());
        $xml->writeElement('CONTRACTAMOUNT', $this->getContractAmount());
        $xml->writeElement('BILLINGPRICING', $this->getLaborPricingOption());
        $xml->writeElement('BILLINGRATE', $this->getLaborPricingDefaultRate());
        $xml->writeElement('EXPENSEPRICING', $this->getExpensePricingOption());
        $xml->writeElement('EXPENSERATE', $this->getExpensePricingDefaultRate());
        $xml->writeElement('POAPPRICING', $this->getApPurchasingPricingOption());
        $xml->writeElement('POAPRATE', $this->getApPurchasingPricingDefaultRate());
        $xml->writeElement('BUDGETAMOUNT', $this->getBudgetedBillingAmount());
        $xml->writeElement('BUDGETEDCOST', $this->getBudgetedCost());
        $xml->writeElement('BUDGETQTY', $this->getBudgetedDuration());
        $xml->writeElement('BUDGETID', $this->getGlBudgetId());
        $xml->writeElement('INVOICEMESSAGE', $this->getInvoiceMessage());
        $xml->writeElement('INVOICECURRENCY', $this->getInvoiceCurrency());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //PROJECT
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
