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

namespace Intacct\Functions\GlobalConsolidations;

use Intacct\FieldTypes\DateType;
use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class WeightedAverageRateRead extends AbstractFunction
{

    /** @var string */
    private $fromCurrency;

    /** @var string */
    private $toCurrency;

    /** @var DateType */
    private $fromDate;

    /** @var DateType */
    private $toDate;

    /**
     * @return string
     */
    public function getFromCurrency()
    {
        return $this->fromCurrency;
    }

    /**
     * @param string $fromCurrency
     */
    public function setFromCurrency($fromCurrency)
    {
        $this->fromCurrency = $fromCurrency;
    }

    /**
     * @return string
     */
    public function getToCurrency()
    {
        return $this->toCurrency;
    }

    /**
     * @param string $toCurrency
     */
    public function setToCurrency($toCurrency)
    {
        $this->toCurrency = $toCurrency;
    }

    /**
     * @return DateType
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param DateType $fromDate
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return DateType
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param DateType $toDate
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('getWARate');

        if (!$this->getFromCurrency()) {
            throw new InvalidArgumentException('From Currency is required to read Weighted Average Rate');
        }
        $xml->writeElement('fromCurrency', $this->getFromCurrency(), true);
        if (!$this->getToCurrency()) {
            throw new InvalidArgumentException('To Currency is required to read Weighted Average Rate');
        }
        $xml->writeElement('toCurrency', $this->getToCurrency(), true);
        if (!$this->getFromDate()) {
            throw new InvalidArgumentException('From Date is required to read Weighted Average Rate');
        }
        // This needs to follow the xs:date format
        $xml->writeElement('fromDate', $this->getFromDate()->format('Y-m-d'), true);
        if (!$this->getToDate()) {
            throw new InvalidArgumentException('To Date is required to read Weighted Average Rate');
        }
        // This needs to follow the xs:date format
        $xml->writeElement('toDate', $this->getToDate()->format('Y-m-d'), true);

        $xml->endElement(); //getWARate

        $xml->endElement(); //function
    }
}
