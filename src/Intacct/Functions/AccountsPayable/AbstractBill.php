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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractBill extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int */
    protected $recordNo;

    /** @var string */
    protected $vendorId;

    /** @var \DateTime */
    protected $transactionDate;

    /** @var \DateTime */
    protected $glPostingDate;

    /** @var string */
    protected $action;

    /** @var string|int */
    protected $summaryRecordNo;

    /** @var string */
    protected $billNumber;

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
    protected $payToContactName;

    /** @var string */
    protected $returnToContactName;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $taxSolutionId;

    /** @var AbstractBillLine[] */
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
     * Get vendor ID
     *
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * Set vendor ID
     *
     * @param string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
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
     * Get bill number
     *
     * @return string
     */
    public function getBillNumber()
    {
        return $this->billNumber;
    }

    /**
     * Set bill number
     *
     * @param string $billNumber
     */
    public function setBillNumber($billNumber)
    {
        $this->billNumber = $billNumber;
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
     * Get pay to contact name
     *
     * @return string
     */
    public function getPayToContactName()
    {
        return $this->payToContactName;
    }

    /**
     * Set pay to contact name
     *
     * @param string $payToContactName
     */
    public function setPayToContactName($payToContactName)
    {
        $this->payToContactName = $payToContactName;
    }

    /**
     * Get return to contact name
     *
     * @return string
     */
    public function getReturnToContactName()
    {
        return $this->returnToContactName;
    }

    /**
     * Set return to contact name
     *
     * @param string $returnToContactName
     */
    public function setReturnToContactName($returnToContactName)
    {
        $this->returnToContactName = $returnToContactName;
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
     * Get Tax Solution Id
     *
     * @return string
     */
    public function getTaxSolutionId()
    {
        return $this->taxSolutionId;
    }

    /**
     * Set Tax Solution Id
     *
     * @param string $taxSolutionId
     */
    public function setTaxSolutionId(string $taxSolutionId)
    {
        $this->taxSolutionId = $taxSolutionId;
    }

    /**
     * Get bill lines
     *
     * @return AbstractBillLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Set bill lines
     *
     * @param AbstractBillLine[] $lines
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
