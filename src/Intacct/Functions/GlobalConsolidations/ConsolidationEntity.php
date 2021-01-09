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

namespace Intacct\Functions\GlobalConsolidations;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ConsolidationEntity
{

    /** @var string */
    private $entityId;

    /** @var float|string */
    private $endingSpotRate;

    /** @var float|string */
    private $weightedAverageRate;

    /**
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * @return float|string
     */
    public function getEndingSpotRate()
    {
        return $this->endingSpotRate;
    }

    /**
     * @param float|string $endingSpotRate
     */
    public function setEndingSpotRate($endingSpotRate)
    {
        $this->endingSpotRate = $endingSpotRate;
    }

    /**
     * @return float|string
     */
    public function getWeightedAverageRate()
    {
        return $this->weightedAverageRate;
    }

    /**
     * @param float|string $weightedAverageRate
     */
    public function setWeightedAverageRate($weightedAverageRate)
    {
        $this->weightedAverageRate = $weightedAverageRate;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('csnentity');

        if (!$this->getEntityId()) {
            throw new InvalidArgumentException('Entity ID is required to consolidate an entity');
        }
        $xml->writeElement('entityid', $this->getEntityId(), true);
        // Rates support up to 10 decimal places
        $bsRate = is_float($this->getEndingSpotRate())
            ? number_format($this->getEndingSpotRate(), 10)
            : $this->getEndingSpotRate();
        $waRate = is_float($this->getWeightedAverageRate())
            ? number_format($this->getWeightedAverageRate(), 10)
            : $this->getWeightedAverageRate();

        $xml->writeElement('bsrate', $bsRate);
        $xml->writeElement('warate', $waRate);

        $xml->endElement(); //csnentity
    }
}
