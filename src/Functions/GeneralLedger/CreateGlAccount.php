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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Xml\XMLWriter;

class CreateGlAccount extends AbstractGlAccount
{

    /**
     * @return string
     */
    public function getAccountNo()
    {
        return $this->accountNo;
    }

    /**
     * @param string $accountNo
     */
    public function setAccountNo($accountNo)
    {
        $this->accountNo = $accountNo;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSystemCategory()
    {
        return $this->systemCategory;
    }

    /**
     * @param string $systemCategory
     */
    public function setSystemCategory($systemCategory)
    {
        $this->systemCategory = $systemCategory;
    }

    /**
     * @return string
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param string $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * @return string
     */
    public function getNormalBalance()
    {
        return $this->normalBalance;
    }

    /**
     * @param string $normalBalance
     */
    public function setNormalBalance($normalBalance)
    {
        $this->normalBalance = $normalBalance;
    }

    /**
     * @return string
     */
    public function getClosingType()
    {
        return $this->closingType;
    }

    /**
     * @param string $closingType
     */
    public function setClosingType($closingType)
    {
        $this->closingType = $closingType;
    }

    /**
     * @return string
     */
    public function getCloseIntoGlAccountNo()
    {
        return $this->closeIntoGlAccountNo;
    }

    /**
     * @param string $closeIntoGlAccountNo
     */
    public function setCloseIntoGlAccountNo($closeIntoGlAccountNo)
    {
        $this->closeIntoGlAccountNo = $closeIntoGlAccountNo;
    }

    /**
     * @return string
     */
    public function getGlAccountAlternative()
    {
        return $this->glAccountAlternative;
    }

    /**
     * @param string $glAccountAlternative
     */
    public function setGlAccountAlternative($glAccountAlternative)
    {
        $this->glAccountAlternative = $glAccountAlternative;
    }

    /**
     * @return string
     */
    public function getTaxReturnCode()
    {
        return $this->taxReturnCode;
    }

    /**
     * @param string $taxReturnCode
     */
    public function setTaxReturnCode($taxReturnCode)
    {
        $this->taxReturnCode = $taxReturnCode;
    }

    /**
     * @return string
     */
    public function getM3ReturnCode()
    {
        return $this->m3ReturnCode;
    }

    /**
     * @param string $m3ReturnCode
     */
    public function setM3ReturnCode($m3ReturnCode)
    {
        $this->m3ReturnCode = $m3ReturnCode;
    }

    /**
     * @return boolean
     */
    public function isTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param boolean $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return boolean
     */
    public function isRequireDepartment()
    {
        return $this->requireDepartment;
    }

    /**
     * @param boolean $requireDepartment
     */
    public function setRequireDepartment($requireDepartment)
    {
        $this->requireDepartment = $requireDepartment;
    }

    /**
     * @return boolean
     */
    public function isRequireLocation()
    {
        return $this->requireLocation;
    }

    /**
     * @param boolean $requireLocation
     */
    public function setRequireLocation($requireLocation)
    {
        $this->requireLocation = $requireLocation;
    }

    /**
     * @return boolean
     */
    public function isRequireProject()
    {
        return $this->requireProject;
    }

    /**
     * @param boolean $requireProject
     */
    public function setRequireProject($requireProject)
    {
        $this->requireProject = $requireProject;
    }

    /**
     * @return boolean
     */
    public function isRequireCustomer()
    {
        return $this->requireCustomer;
    }

    /**
     * @param boolean $requireCustomer
     */
    public function setRequireCustomer($requireCustomer)
    {
        $this->requireCustomer = $requireCustomer;
    }

    /**
     * @return boolean
     */
    public function isRequireVendor()
    {
        return $this->requireVendor;
    }

    /**
     * @param boolean $requireVendor
     */
    public function setRequireVendor($requireVendor)
    {
        $this->requireVendor = $requireVendor;
    }

    /**
     * @return boolean
     */
    public function isRequireEmployee()
    {
        return $this->requireEmployee;
    }

    /**
     * @param boolean $requireEmployee
     */
    public function setRequireEmployee($requireEmployee)
    {
        $this->requireEmployee = $requireEmployee;
    }

    /**
     * @return boolean
     */
    public function isRequireItem()
    {
        return $this->requireItem;
    }

    /**
     * @param boolean $requireItem
     */
    public function setRequireItem($requireItem)
    {
        $this->requireItem = $requireItem;
    }

    /**
     * @return boolean
     */
    public function isRequireClass()
    {
        return $this->requireClass;
    }

    /**
     * @param boolean $requireClass
     */
    public function setRequireClass($requireClass)
    {
        $this->requireClass = $requireClass;
    }

    /**
     * @return boolean
     */
    public function isRequireContract()
    {
        return $this->requireContract;
    }

    /**
     * @param boolean $requireContract
     */
    public function setRequireContract($requireContract)
    {
        $this->requireContract = $requireContract;
    }

    /**
     * @return boolean
     */
    public function isRequireWarehouse()
    {
        return $this->requireWarehouse;
    }

    /**
     * @param boolean $requireWarehouse
     */
    public function setRequireWarehouse($requireWarehouse)
    {
        $this->requireWarehouse = $requireWarehouse;
    }

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
            'account_no' => null,
            'title' => null,
            'system_category' => null,
            'account_type' => null,
            'normal_balance' => null,
            'closing_type' => null,
            'close_into_gl_account_no' => null,
            'gl_account_alternative' => null,
            'tax_return_code' => null,
            'm3_return_cose' => null,
            'taxable' => null,
            'active' => null,
            'require_department' => null,
            'require_location' => null,
            'require_project' => null,
            'require_customer' => null,
            'require_vendor' => null,
            'require_employee' => null,
            'require_item' => null,
            'require_class' => null,
            'require_contract' => null,
            'require_warehouse' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setAccountNo($config['account_no']);
        $this->setTitle($config['title']);
        $this->setSystemCategory($config['system_category']);
        $this->setAccountType($config['account_type']);
        $this->setNormalBalance($config['normal_balance']);
        $this->setClosingType($config['closing_type']);
        $this->setCloseIntoGlAccountNo($config['close_into_gl_account_no']);
        $this->setGlAccountAlternative($config['gl_account_alternative']);
        $this->setTaxReturnCode($config['tax_return_code']);
        $this->setM3ReturnCode($config['m3_return_cose']);
        $this->setTaxable($config['taxable']);
        $this->setActive($config['active']);
        $this->setRequireDepartment($config['require_department']);
        $this->setRequireLocation($config['require_location']);
        $this->setRequireProject($config['require_project']);
        $this->setRequireCustomer($config['require_customer']);
        $this->setRequireVendor($config['require_vendor']);
        $this->setRequireEmployee($config['require_employee']);
        $this->setRequireItem($config['require_item']);
        $this->setRequireClass($config['require_class']);
        $this->setRequireContract($config['require_contract']);
        $this->setRequireWarehouse($config['require_warehouse']);
        $this->setCustomFields($config['custom_fields']);
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
        $xml->startElement('GLACCOUNT');

        $xml->writeElement('ACCOUNTNO', $this->getAccountNo(), true);
        $xml->writeElement('TITLE', $this->getTitle(), true);
        $xml->writeElement('CATEGORY', $this->getSystemCategory());
        $xml->writeElement('ACCOUNTTYPE', $this->getAccountType(), true);
        $xml->writeElement('NORMALBALANCE', $this->getNormalBalance(), true);
        $xml->writeElement('CLOSINGTYPE', $this->getClosingType(), true);
        $xml->writeElement('CLOSINGACCOUNTNO', $this->getCloseIntoGlAccountNo());
        $xml->writeElement('TAXCODE', $this->getTaxReturnCode());
        $xml->writeElement('MRCCODE', $this->getM3ReturnCode());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $xml->writeElement('TAXABLE', $this->isTaxable());
        $xml->writeElement('REQUIREDEPT', $this->isRequireDepartment());
        $xml->writeElement('REQUIRELOC', $this->isRequireLocation());
        $xml->writeElement('REQUIREPROJECT', $this->isRequireProject());
        $xml->writeElement('REQUIRECUSTOMER', $this->isRequireCustomer());
        $xml->writeElement('REQUIREVENDOR', $this->isRequireVendor());
        $xml->writeElement('REQUIREEMPLOYEE', $this->isRequireEmployee());
        $xml->writeElement('REQUIREITEM', $this->isRequireItem());
        $xml->writeElement('REQUIRECLASS', $this->isRequireClass());
        $xml->writeElement('REQUIRECONTRACT', $this->isRequireContract());
        $xml->writeElement('REQUIREWAREHOUSE', $this->isRequireWarehouse());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //GLACCOUNT
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
