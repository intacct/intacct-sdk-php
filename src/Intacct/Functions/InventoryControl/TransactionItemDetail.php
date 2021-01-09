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

class TransactionItemDetail extends AbstractTransactionItemDetail
{

    /**
     * Write the itemdetail block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('itemdetail');

        $xml->writeElement('quantity', $this->getQuantity());

        if ($this->getSerialNumber()) {
            $xml->writeElement('serialno', $this->getSerialNumber());
        }

        if ($this->getLotNumber()) {
            $xml->writeElement('lotno', $this->getLotNumber());
        }

        $xml->writeElement('aisle', $this->getAisle());
        $xml->writeElement('row', $this->getRow());
        $xml->writeElement('bin', $this->getBin());

        if ($this->getItemExpiration()) {
            $xml->startElement('itemexpiration');
            $xml->writeDateSplitElements($this->getItemExpiration());
            $xml->endElement(); //itemexpiration
        }

        $xml->endElement(); //itemdetail
    }
}
