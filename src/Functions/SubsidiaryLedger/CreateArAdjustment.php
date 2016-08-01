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

namespace Intacct\Functions\SubsidiaryLedger;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateArAdjustment extends AbstractArTransaction
{
    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return Date
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param Date $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * @return Date
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * @param Date $glPostingDate
     */
    public function setGlPostingDate($glPostingDate)
    {
        $this->glPostingDate = $glPostingDate;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return int|string
     */
    public function getBatchKey()
    {
        return $this->batchKey;
    }

    /**
     * @param int|string $batchKey
     */
    public function setBatchKey($batchKey)
    {
        $this->batchKey = $batchKey;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

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
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * @return Date
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * @param Date $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        $this->exchangeRateDate = $exchangeRateDate;
    }

    /**
     * @return float
     */
    public function getExchangeRateValue()
    {
        return $this->exchangeRateValue;
    }

    /**
     * @param float $exchangeRateValue
     */
    public function setExchangeRateValue($exchangeRateValue)
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

    /**
     * @return string
     */
    public function getExchangeRateType()
    {
        return $this->exchangeRateType;
    }

    /**
     * @param string $exchangeRateType
     */
    public function setExchangeRateType($exchangeRateType)
    {
        $this->exchangeRateType = $exchangeRateType;
    }

    /**
     * @return boolean
     */
    public function isDoNotPostToGL()
    {
        return $this->doNotPostToGL;
    }

    /**
     * @param boolean $doNotPostToGL
     */
    public function setDoNotPostToGL($doNotPostToGL)
    {
        $this->doNotPostToGL = $doNotPostToGL;
    }

    /**
     * @return string
     */
    public function getAdjustmentNumber()
    {
        return $this->adjustmentNumber;
    }

    /**
     * @param string $adjustmentNumber
     */
    public function setAdjustmentNumber($adjustmentNumber)
    {
        $this->adjustmentNumber = $adjustmentNumber;
    }

    /**
     * @return array
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param array $entries
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'customer_id' => null,
            'transaction_date' => null,
            'gl_posting_date' => null,
            'action' => null,
            'batch_key' => null,
            'invoice_number' => null,
            'description' => null,
            'external_id' => null,
            'base_currency' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'do_not_post_to_gl' => null,
            'adjustment_number' => null,
            'custom_fields' => [],
            'entries' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setCustomerId($config['customer_id']);
        $this->setTransactionDate($config['transaction_date']);
        $this->setGlPostingDate($config['gl_posting_date']);
        $this->setAction($config['action']);
        $this->setBatchKey($config['batch_key']);
        $this->setInvoiceNumber($config['invoice_number']);
        $this->setDescription($config['description']);
        $this->setExternalId($config['external_id']);
        $this->setBaseCurrency($config['base_currency']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->setDoNotPostToGL($config['do_not_post_to_gl']);
        $this->setAdjustmentNumber($config['adjustment_number']);
        $this->setCustomFields($config['custom_fields']);
        $this->setEntries($config['entries']);
    }

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

        $xml->startElement('create_aradjustment');

        $xml->writeElement('customerid', $this->getCustomerId(), true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate());
        $xml->endElement(); //datecreated

        if ($this->getGlPostingDate()) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('batchkey', $this->getBatchKey());
        $xml->writeElement('adjustmentno', $this->getAdjustmentNumber());
        $xml->writeElement('action', $this->getAction());
        $xml->writeElement('invoiceno', $this->getInvoiceNumber());
        $xml->writeElement('description', $this->getDescription());
        $xml->writeElement('externalid', $this->getExternalId());

        $this->writeXmlMultiCurrencySection($xml);

        $xml->writeElement('nogl', $this->isDoNotPostToGL());

        $xml->startElement('aradjustmentitems');
        if (count($this->getEntries()) > 0) {
            foreach ($this->getEntries() as $entry) {
                if ($entry instanceof CreateArAdjustmentEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreateArAdjustmentEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('AR Adjustment "entries" param must have at least 1 entry');
        }
        $xml->endElement(); //aradjustmentitems

        $xml->endElement(); //create_aradjustment

        $xml->endElement(); //function
    }
}
