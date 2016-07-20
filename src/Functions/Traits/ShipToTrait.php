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

namespace Intacct\Functions\Traits;

use Intacct\Xml\XMLWriter;

trait ShipToTrait
{

    /**
     * @var string
     */
    private $shipToContactName;

    /**
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * @param XMLWriter $xml
     */
    public function getShipToContactNameXml(XMLWriter &$xml)
    {
        if (is_null($this->shipToContactName) == false) {
            $xml->startElement('shipto');
            $xml->writeElement('contactname', $this->shipToContactName);
            $xml->endElement(); //shipto
        }
    }

}