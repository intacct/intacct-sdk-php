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
 * Update an existing location record
 */
class LocationUpdate extends AbstractLocation
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
        $xml->startElement('LOCATION');

        if (!$this->getLocationId()) {
            throw new InvalidArgumentException('Location ID is required for update');
        }
        $xml->writeElement('LOCATIONID', $this->getLocationId(), true);

        $xml->writeElement('NAME', $this->getLocationName());
        $xml->writeElement('PARENTID', $this->getParentLocationId());
        $xml->writeElement('SUPERVISORID', $this->getManagerEmployeeId());

        if ($this->getLocationContactName() !== null) {
            $xml->startElement('CONTACTINFO');
            $xml->writeElement('CONTACTNAME', $this->getLocationContactName());
            $xml->endElement();
        }

        if ($this->getShipToContactName() !== null) {
            $xml->startElement('SHIPTO');
            $xml->writeElement('CONTACTNAME', $this->getShipToContactName());
            $xml->endElement();
        }

        $xml->writeElementDate('STARTDATE', $this->getStartDate());
        $xml->writeElementDate('ENDDATE', $this->getEndDate());
        $xml->writeElement('CUSTTITLE', $this->getLocationTitle());

        if ($this->isActive() === true) {
            $xml->writeElement('STATUS', 'active');
        } elseif ($this->isActive() === false) {
            $xml->writeElement('STATUS', 'inactive');
        }

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //LOCATION
        $xml->endElement(); //update

        $xml->endElement(); //function
    }
}
