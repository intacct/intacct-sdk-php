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

namespace Intacct\Functions\Traits;

use Intacct\Xml\XMLWriter;
use Intacct\Fields\Date;
use InvalidArgumentException;

trait ExchangeRateInfoTrait
{
    use ExchangeRateTypeTrait;

    /**
     *
     * @var string
     */
    private $baseCurrency;

    /**
     *
     * @var string
     */
    private $transactionCurrency;

    /**
     *
     * @var Date
     */
    private $exchangeRateDate;

    /**
     *
     * @var float
     */
    private $exchangeRateValue;

    /**
     * @param string $baseCurrency
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string|Date $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        if ($exchangeRateDate instanceof Date) {
            $this->exchangeRateDate = $exchangeRateDate;
        } elseif (is_null($exchangeRateDate) == false) {
            $this->exchangeRateDate = new Date($exchangeRateDate);
        }
    }

    /**
     * @param string|number $exchangeRate
     * @throws InvalidArgumentException
     */
    public function setExchangeRateValue($exchangeRate)
    {
        if (is_numeric($exchangeRate) || is_null($exchangeRate)) {
            $this->exchangeRateValue = $exchangeRate;
        } else {
            throw new InvalidArgumentException('exchange_rate is not a valid number');
        }
    }

    /**
     * @param XMLWriter $xml
     */
    public function getExchangeRateInfoXml(XMLWriter &$xml)
    {
        $xml->writeElement('basecurr', $this->baseCurrency);
        $xml->writeElement('currency', $this->transactionCurrency);

        if ($this->exchangeRateDate) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->exchangeRateDate, true);
            $xml->endElement();
        }

        if ($this->exchangeRateType) {
            $xml->writeElement('exchratetype', $this->exchangeRateType);
        } elseif ($this->exchangeRateValue) {
            $xml->writeElement('exchrate', $this->exchangeRateValue);
        } elseif ($this->baseCurrency || $this->transactionCurrency) {
            $xml->writeElement('exchratetype', $this->exchangeRateType, true);
        }
    }
}
