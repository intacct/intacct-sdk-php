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

class CreateArInvoice extends AbstractArTransaction
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
     * @return Date
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param Date $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    /**
     * @param string $paymentTerm
     */
    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;
    }

    /**
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @param string $referenceNumber
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * @return boolean
     */
    public function isOnHold()
    {
        return $this->onHold;
    }

    /**
     * @param boolean $onHold
     */
    public function setOnHold($onHold)
    {
        $this->onHold = $onHold;
    }

    /**
     * @return string
     */
    public function getBillToContactName()
    {
        return $this->billToContactName;
    }

    /**
     * @param string $billToContactName
     */
    public function setBillToContactName($billToContactName)
    {
        $this->billToContactName = $billToContactName;
    }

    /**
     * @return string
     */
    public function getShipToContactName()
    {
        return $this->shipToContactName;
    }

    /**
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * @return string
     */
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
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
            'due_date' => null,
            'payment_term' => null,
            'reference_number' => null,
            'on_hold' => null,
            'bill_to_contact_name' => null,
            'ship_to_contact_name' => null,
            'attachments_id' => null,
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
        $this->setDueDate($config['due_date']);
        $this->setPaymentTerm($config['payment_term']);
        $this->setReferenceNumber($config['reference_number']);
        $this->setOnHold($config['on_hold']);
        $this->setBillToContactName($config['bill_to_contact_name']);
        $this->setShipToContactName($config['ship_to_contact_name']);
        $this->setAttachmentsId($config['attachments_id']);
        $this->setCustomFields($config['custom_fields']);
        $this->setEntries($config['entries']);
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_invoice');

        $xml->writeElement('customerid', $this->getCustomerId(), true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate(), true);
        $xml->endElement(); //datecreated

        if ($this->getGlPostingDate()) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        if ($this->getDueDate()) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->getDueDate(), true);
            $xml->endElement(); // datedue

            $xml->writeElement('termname', $this->getPaymentTerm());
        } else {
            $xml->writeElement('termname', $this->getPaymentTerm(), true);
        }

        $xml->writeElement('action', $this->getAction());
        $xml->writeElement('batchkey', $this->getBatchKey());
        $xml->writeElement('invoiceno', $this->getInvoiceNumber());
        $xml->writeElement('ponumber', $this->getReferenceNumber());
        $xml->writeElement('onhold', $this->isOnHold());
        $xml->writeElement('description', $this->getDescription());
        $xml->writeElement('externalid', $this->getExternalId());

        if ($this->getBillToContactName()) {
            $xml->startElement('billto');
            $xml->writeElement('contactname', $this->getBillToContactName(), true);
            $xml->endElement(); //billto
        }

        if ($this->getShipToContactName()) {
            $xml->startElement('shipto');
            $xml->writeElement('contactname', $this->getShipToContactName(), true);
            $xml->endElement(); //shipto
        }

        $this->writeXmlMultiCurrencySection($xml);

        $xml->writeElement('nogl', $this->isDoNotPostToGL());
        $xml->writeElement('supdocid', $this->getAttachmentsId());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->startElement('invoiceitems');
        if (count($this->getEntries()) > 0) {
            foreach ($this->getEntries() as $entry) {
                if ($entry instanceof CreateArInvoiceEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreateArInvoiceEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('AR Invoice "entries" param must have at least 1 entry');
        }
        $xml->endElement(); //invoiceitems

        $xml->endElement(); //create_invoice

        $xml->endElement(); //function
    }
}
