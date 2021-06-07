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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractInvoice extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $customerId;

    /** @var \DateTime */
    protected $transactionDate;

    /** @var \DateTime */
    protected $glPostingDate;

    /** @var string */
    protected $action;

    /** @var string|int */
    protected $summaryRecordNo;

    /** @var string */
    protected $invoiceNumber;

    /** @var string */
    protected $description;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $baseCurrency;

    /** @var string */
    protected $transactionCurrency;

    /** @var \DateTime */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var bool */
    protected $doNotPostToGL;

    /** @var \DateTime */
    protected $dueDate;

    /** @var string */
    protected $paymentTerm;

    /** @var string */
    protected $referenceNumber;

    /** @var bool */
    protected $onHold;

    /** @var string */
    protected $billToContactName;

    /** @var string */
    protected $shipToContactName;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $taxSolutionId;

    /** @var AbstractInvoiceLine[] */
    protected $lines = [];

    /**
     * Get record number
     *
     * @return int|string
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * Set record number
     *
     * @param int|string $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
    }

    /**
     * Get customer ID
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customer ID
     *
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Get transaction date
     *
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * Set transaction date
     *
     * @param \DateTime $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * Get GL posting date
     *
     * @return \DateTime
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * Set GL posting date
     *
     * @param \DateTime $glPostingDate
     */
    public function setGlPostingDate($glPostingDate)
    {
        $this->glPostingDate = $glPostingDate;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get summary record number
     *
     * @return int|string
     */
    public function getSummaryRecordNo()
    {
        return $this->summaryRecordNo;
    }

    /**
     * Set summary record number
     *
     * @param int|string $summaryRecordNo
     */
    public function setSummaryRecordNo($summaryRecordNo)
    {
        $this->summaryRecordNo = $summaryRecordNo;
    }

    /**
     * Get invoice number
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set invoice number
     *
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get external ID
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Set external ID
     *
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }

    /**
     * Get base currency
     *
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * Set base currency
     *
     * @param string $baseCurrency
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * Get transaction currency
     *
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * Set transaction currency
     *
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * Get exchange rate date
     *
     * @return \DateTime
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * Set exchange rate date
     *
     * @param \DateTime $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        $this->exchangeRateDate = $exchangeRateDate;
    }

    /**
     * Get exchange rate value
     *
     * @return float
     */
    public function getExchangeRateValue()
    {
        return $this->exchangeRateValue;
    }

    /**
     * Set exchange rate value
     *
     * @param float $exchangeRateValue
     */
    public function setExchangeRateValue($exchangeRateValue)
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

    /**
     * Get exchange rate type
     *
     * @return string
     */
    public function getExchangeRateType()
    {
        return $this->exchangeRateType;
    }

    /**
     * Set exchange rate type
     *
     * @param string $exchangeRateType
     */
    public function setExchangeRateType($exchangeRateType)
    {
        $this->exchangeRateType = $exchangeRateType;
    }

    /**
     * Get do not post to general ledger
     *
     * @return bool
     */
    public function isDoNotPostToGL()
    {
        return $this->doNotPostToGL;
    }

    /**
     * Set do not post to general ledger
     *
     * @param bool $doNotPostToGL
     */
    public function setDoNotPostToGL($doNotPostToGL)
    {
        $this->doNotPostToGL = $doNotPostToGL;
    }

    /**
     * Get due date
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set due date
     *
     * @param \DateTime $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Get payment term
     *
     * @return string
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    /**
     * Set payment term
     *
     * @param string $paymentTerm
     */
    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;
    }

    /**
     * Get reference number
     *
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * Set reference number
     *
     * @param string $referenceNumber
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * Get on hold
     *
     * @return bool
     */
    public function isOnHold()
    {
        return $this->onHold;
    }

    /**
     * Set on hold
     *
     * @param bool $onHold
     */
    public function setOnHold($onHold)
    {
        $this->onHold = $onHold;
    }

    /**
     * Get bill to contact name
     *
     * @return string
     */
    public function getBillToContactName()
    {
        return $this->billToContactName;
    }

    /**
     * Set bill to contact name
     *
     * @param string $billToContactName
     */
    public function setBillToContactName($billToContactName)
    {
        $this->billToContactName = $billToContactName;
    }

    /**
     * Get ship to contact name
     *
     * @return string
     */
    public function getShipToContactName()
    {
        return $this->shipToContactName;
    }

    /**
     * Set ship to contact name
     *
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * Get attachments ID
     *
     * @return string
     */
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * Set attachments ID
     *
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
    }

    /**
     * @return string
     */
    public function getTaxSolutionId()
    {
        return $this->taxSolutionId;
    }

    /**
     * @param string $taxSolutionId
     */
    public function setTaxSolutionId(string $taxSolutionId)
    {
        $this->taxSolutionId = $taxSolutionId;
    }

    /**
     * Get invoice lines
     *
     * @return AbstractInvoiceLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Set invoice lines
     *
     * @param AbstractInvoiceLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * @param XMLWriter $xml
     */
    protected function writeXmlMultiCurrencySection(XMLWriter &$xml)
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
