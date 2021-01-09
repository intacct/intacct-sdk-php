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

namespace Intacct\Functions\Purchasing;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\InventoryControl\AbstractTransactionSubtotal;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractPurchasingTransaction extends AbstractFunction
{

    /** @var string */
    const STATE_DRAFT = 'Draft';

    /** @var string */
    const STATE_PENDING = 'Pending';

    /** @var string */
    const STATE_CLOSED = 'Closed';

    use CustomFieldsTrait;

    /** @var string */
    protected $documentId;

    /** @var string */
    protected $transactionDefinition;

    /** @var \DateTime */
    protected $transactionDate;

    /** @var \DateTime */
    protected $glPostingDate;

    /** @var string */
    protected $createdFrom;

    /** @var string */
    protected $vendorId;

    /** @var string */
    protected $vendorDocNumber;

    /** @var string */
    protected $documentNumber;

    /** @var \DateTime */
    protected $originalDocumentDate;

    /** @var string */
    protected $referenceNumber;

    /** @var string */
    protected $paymentTerm;

    /** @var \DateTime */
    protected $dueDate;

    /** @var string */
    protected $message;

    /** @var string */
    protected $shippingMethod;

    /** @var string */
    protected $returnToContactName;

    /** @var string */
    protected $payToContactName;

    /** @var string */
    protected $attachmentsId;

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

    /** @var string */
    protected $vsoePriceList;

    /** @var string */
    protected $state;

    /** @var string */
    protected $projectId;

    /** @var AbstractTransactionSubtotal[] */
    protected $subtotals = [];

    /** @var AbstractPurchasingTransactionLine[] */
    protected $lines = [];

    /** @var string */
    protected $comment;

    /**
     * @return string
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @param string $documentId
     */
    public function setRecordNo($documentId)
    {
        $this->documentId = $documentId;
    }

    /**
     * @return string
     */
    public function getTransactionDefinition()
    {
        return $this->transactionDefinition;
    }

    /**
     * @param string $transactionDefinition
     */
    public function setTransactionDefinition($transactionDefinition)
    {
        $this->transactionDefinition = $transactionDefinition;
    }

    /**
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param \DateTime $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * @return \DateTime
     */
    public function getGlPostingDate()
    {
        return $this->glPostingDate;
    }

    /**
     * @param \DateTime $glPostingDate
     */
    public function setGlPostingDate($glPostingDate)
    {
        $this->glPostingDate = $glPostingDate;
    }

    /**
     * @return string
     */
    public function getCreatedFrom()
    {
        return $this->createdFrom;
    }

    /**
     * @param string $createdFrom
     */
    public function setCreatedFrom($createdFrom)
    {
        $this->createdFrom = $createdFrom;
    }

    /**
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @return string
     */
    public function getVendorDocNumber()
    {
        return $this->vendorDocNumber;
    }

    /**
     * @param string $vendorDocNumber
     */
    public function setVendorDocNumber($vendorDocNumber)
    {
        $this->vendorDocNumber = $vendorDocNumber;
    }

    /**
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     */
    public function setDocumentNumber($documentNumber)
    {
        $this->documentNumber = $documentNumber;
    }

    /**
     * @return \DateTime
     */
    public function getOriginalDocumentDate()
    {
        return $this->originalDocumentDate;
    }

    /**
     * @param \DateTime $originalDocumentDate
     */
    public function setOriginalDocumentDate($originalDocumentDate)
    {
        $this->originalDocumentDate = $originalDocumentDate;
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
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param string $shippingMethod
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return string
     */
    public function getReturnToContactName()
    {
        return $this->returnToContactName;
    }

    /**
     * @param string $returnToContactName
     */
    public function setReturnToContactName($returnToContactName)
    {
        $this->returnToContactName = $returnToContactName;
    }

    /**
     * @return string
     */
    public function getPayToContactName()
    {
        return $this->payToContactName;
    }

    /**
     * @param string $payToContactName
     */
    public function setPayToContactName($payToContactName)
    {
        $this->payToContactName = $payToContactName;
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
     * @return \DateTime
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * @param \DateTime $exchangeRateDate
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
     * @return string
     */
    public function getVsoePriceList()
    {
        return $this->vsoePriceList;
    }

    /**
     * @param string $vsoePriceList
     */
    public function setVsoePriceList($vsoePriceList)
    {
        $this->vsoePriceList = $vsoePriceList;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return AbstractTransactionSubtotal[]
     */
    public function getSubtotals()
    {
        return $this->subtotals;
    }

    /**
     * @param AbstractTransactionSubtotal[] $subtotals
     */
    public function setSubtotals($subtotals)
    {
        $this->subtotals = $subtotals;
    }

    /**
     * @return AbstractPurchasingTransactionLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractPurchasingTransactionLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
