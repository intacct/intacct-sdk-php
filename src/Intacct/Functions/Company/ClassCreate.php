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

namespace Intacct\Functions\Company;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new class record
 */
class ClassCreate extends AbstractClass
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
        $xml->startElement('CLASS');

        if (!$this->getClassId()) {
            throw new InvalidArgumentException('Class ID is required for create');
        }
        $xml->writeElement('CLASSID', $this->getClassId(), true);
        if (!$this->getClassName()) {
            throw new InvalidArgumentException('Class Name is required for create');
        }
        $xml->writeElement('NAME', $this->getClassName(), true);

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('PARENTID', $this->getParentClassId());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //CLASS
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
