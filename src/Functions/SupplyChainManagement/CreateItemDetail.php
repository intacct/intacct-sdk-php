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

namespace Intacct\Functions\SupplyChainManagement;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;

class CreateItemDetail extends AbstractItemDetail
{

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @return string
     */
    public function getLotNumber()
    {
        return $this->lotNumber;
    }

    /**
     * @param string $lotNumber
     */
    public function setLotNumber($lotNumber)
    {
        $this->lotNumber = $lotNumber;
    }

    /**
     * @return string
     */
    public function getAisle()
    {
        return $this->aisle;
    }

    /**
     * @param string $aisle
     */
    public function setAisle($aisle)
    {
        $this->aisle = $aisle;
    }

    /**
     * @return string
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param string $row
     */
    public function setRow($row)
    {
        $this->row = $row;
    }

    /**
     * @return string
     */
    public function getBin()
    {
        return $this->bin;
    }

    /**
     * @param string $bin
     */
    public function setBin($bin)
    {
        $this->bin = $bin;
    }

    /**
     * @return Date
     */
    public function getItemExpiration()
    {
        return $this->itemExpiration;
    }

    /**
     * @param Date $itemExpiration
     */
    public function setItemExpiration($itemExpiration)
    {
        $this->itemExpiration = $itemExpiration;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var int|float|string $quantity
     *      @var string $serial_number
     *      @var string $lot_number
     *      @var string $aisle
     *      @var string $row
     *      @var string $bin
     *      @var Date $item_expiration
     * }
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

        $this->setQuantity($config['quantity']);
        $this->setSerialNumber($config['serial_number']);
        $this->setLotNumber($config['lot_number']);
        $this->setAisle($config['aisle']);
        $this->setRow($config['row']);
        $this->setBin($config['bin']);
        $this->setItemExpiration($config['item_expiration']);
    }

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
        } elseif ($this->getLotNumber()) {
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
