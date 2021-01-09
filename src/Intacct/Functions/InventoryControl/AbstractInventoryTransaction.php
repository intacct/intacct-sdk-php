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

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractInventoryTransaction extends AbstractFunction
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

    /** @var string */
    protected $createdFrom;

    /** @var string */
    protected $documentNumber;

    /** @var string */
    protected $referenceNumber;

    /** @var string */
    protected $message;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $baseCurrency;

    /** @var string */
    protected $state;

    /** @var AbstractTransactionSubtotal[] */
    protected $subtotals = [];

    /** @var AbstractInventoryTransactionLine[] */
    protected $lines = [];

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
    public function setDocumentId($documentId)
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
     * @return AbstractInventoryTransactionLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractInventoryTransactionLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
