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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateApAccountLabel extends AbstractAccountLabel
{

    /**
     * @return string
     */
    public function getAccountLabel()
    {
        return $this->accountLabel;
    }

    /**
     * @param string $accountLabel
     */
    public function setAccountLabel($accountLabel)
    {
        $this->accountLabel = $accountLabel;
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
            'account_label' => null,
            'description' => null,
            'gl_account_no' => null,
            'offset_gl_account_no' => null,
            'active' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setAccountLabel($config['account_label']);
        $this->setDescription($config['description']);
        $this->setGlAccountNo($config['gl_account_no']);
        $this->setOffsetGlAccountNo($config['offset_gl_account_no']);
        $this->setActive($config['active']);
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
        $xml->startElement('APACCOUNTLABEL');

        if (!$this->getAccountLabel()) {
            throw new InvalidArgumentException('Account Label is required for create');
        }
        $xml->writeElement('ACCOUNTLABEL', $this->getAccountLabel(), true);
        $xml->writeElement('DESCRIPTION', $this->getDescription(), true);
        $xml->writeElement('GLACCOUNTNO', $this->getGlAccountNo(), true);

        $xml->writeElement('OFFSETGLACCOUNTNO', $this->getOffsetGlAccountNo());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $xml->endElement(); //APACCOUNTLABEL
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
