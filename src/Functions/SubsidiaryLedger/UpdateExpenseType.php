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

namespace Intacct\Functions\SubsidiaryLedger;

use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class UpdateExpenseType extends AbstractAccountLabel
{

    use CustomFieldsTrait;

    /**
     * @return string
     */
    public function getExpenseType()
    {
        return $this->expenseType;
    }

    /**
     * @param string $expenseType
     */
    public function setExpenseType($expenseType)
    {
        $this->expenseType = $expenseType;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getGlAccountNo()
    {
        return $this->glAccountNo;
    }

    /**
     * @param string $glAccountNo
     */
    public function setGlAccountNo($glAccountNo)
    {
        $this->glAccountNo = $glAccountNo;
    }

    /**
     * @return string
     */
    public function getOffsetGlAccountNo()
    {
        return $this->offsetGlAccountNo;
    }

    /**
     * @param string $offsetGlAccountNo
     */
    public function setOffsetGlAccountNo($offsetGlAccountNo)
    {
        $this->offsetGlAccountNo = $offsetGlAccountNo;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
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
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'expense_type' => null,
            'description' => null,
            'gl_account_no' => null,
            'offset_gl_account_no' => null,
            'item_id' => null,
            'active' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setExpenseType($config['expense_type']);
        $this->setDescription($config['description']);
        $this->setGlAccountNo($config['gl_account_no']);
        $this->setOffsetGlAccountNo($config['offset_gl_account_no']);
        $this->setItemId($config['item_id']);
        $this->setActive($config['active']);
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

        $xml->startElement('update');
        $xml->startElement('EEACCOUNTLABEL');

        if (!$this->getExpenseType()) {
            throw new InvalidArgumentException('Expense Type is required for update');
        }
        $xml->writeElement('ACCOUNTLABEL', $this->getExpenseType(), true);

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('GLACCOUNTNO', $this->getGlAccountNo());
        $xml->writeElement('OFFSETGLACCOUNTNO', $this->getOffsetGlAccountNo());
        $xml->writeElement('ITEMID', $this->getItemId());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //EEACCOUNTLABEL
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
