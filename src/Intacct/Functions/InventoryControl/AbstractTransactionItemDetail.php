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

abstract class AbstractTransactionItemDetail
{
    
    /** @var string */
    protected $quantity;

    /** @var string */
    protected $serialNumber;

    /** @var string */
    protected $lotNumber;

    /** @var string */
    protected $aisle;

    /** @var string */
    protected $row;

    /** @var string */
    protected $bin;

    /** @var \DateTime */
    protected $itemExpiration;

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
     * @return \DateTime
     */
    public function getItemExpiration()
    {
        return $this->itemExpiration;
    }

    /**
     * @param \DateTime $itemExpiration
     */
    public function setItemExpiration($itemExpiration)
    {
        $this->itemExpiration = $itemExpiration;
    }

    abstract public function writeXml(XMLWriter &$xml);
}
