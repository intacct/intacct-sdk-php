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

namespace Intacct\Functions\OrderEntry;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;

class CreateItemDetail
{

    /**
     * @var string
     */
    private $quantity;

    /**
     * @var string
     */
    private $serialNumber;

    /**
     * @var string
     */
    private $lotNumber;

    /**
     * @var string
     */
    private $aisle;

    /**
     * @var string
     */
    private $row;

    /**
     * @var  string
     */
    private $bin;

    /**
     * @var string | Date
     */
    private $itemExpiration;

    /**
     * CreateItemDetail constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'quantity' => null,
            'serial_number' => null,
            'lot_number' => null,
            'aisle' => null,
            'row' => null,
            'bin' => null,
            'item_expiration' => null,
        ];
        $config = array_merge($defaults, $params);

        $this->quantity = $config['quantity'];
        $this->serialNumber = $config['serial_number'];
        $this->lotNumber = $config['lot_number'];
        $this->aisle = $config['aisle'];
        $this->row = $config['row'];
        $this->bin = $config['bin'];
        $this->setItemExpiration($config['item_expiration']);
    }

    /**
     * @param string|Date $itemExpiration
     */
    private function setItemExpiration($itemExpiration)
    {
        if (is_null($itemExpiration) || $itemExpiration instanceof Date) {
            $this->itemExpiration = $itemExpiration;
        } else {
            $this->itemExpiration = new Date($itemExpiration);
        }
    }

    /**
     * @param XMLWriter $xml
     */
    private function getSerialOrLotNumberXml(XMLWriter &$xml)
    {
        if ($this->serialNumber) {
            $xml->writeElement('serialno', $this->serialNumber);
        } else {
            $xml->writeElement('lotno', $this->lotNumber);
        }
    }

    /**
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('itemdetail');

        $xml->writeElement('quantity', $this->quantity);

        $this->getSerialOrLotNumberXml($xml);

        $xml->writeElement('aisle', $this->aisle);
        $xml->writeElement('row', $this->row);
        $xml->writeElement('bin', $this->bin);

        if ($this->itemExpiration) {
            $xml->startElement('itemexpiration');
            $xml->writeDateSplitElements($this->itemExpiration);
            $xml->endElement(); //itemexpiration
        }

        $xml->endElement(); //itemdetail
    }
}