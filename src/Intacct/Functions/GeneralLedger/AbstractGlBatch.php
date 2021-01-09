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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractGlBatch extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int|string */
    protected $recordNo;

    /** @var string */
    protected $journalSymbol;

    /** @var \DateTime */
    protected $postingDate;

    /** @var \DateTime */
    protected $reverseDate;

    /** @var string */
    protected $description;

    /** @var string */
    protected $historyComment;

    /** @var string */
    protected $referenceNumber;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $action;

    /** @var AbstractGlEntry[] */
    protected $lines = [];

    /**
     * @return int|string
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * @param int|string $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
    }

    /**
     * @return string
     */
    public function getJournalSymbol()
    {
        return $this->journalSymbol;
    }

    /**
     * @param string $journalSymbol
     */
    public function setJournalSymbol($journalSymbol)
    {
        $this->journalSymbol = $journalSymbol;
    }

    /**
     * @return \DateTime
     */
    public function getPostingDate()
    {
        return $this->postingDate;
    }

    /**
     * @param \DateTime $postingDate
     */
    public function setPostingDate($postingDate)
    {
        $this->postingDate = $postingDate;
    }

    /**
     * @return \DateTime
     */
    public function getReverseDate()
    {
        return $this->reverseDate;
    }

    /**
     * @param \DateTime $reverseDate
     */
    public function setReverseDate($reverseDate)
    {
        $this->reverseDate = $reverseDate;
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
    public function getHistoryComment()
    {
        return $this->historyComment;
    }

    /**
     * @param string $historyComment
     */
    public function setHistoryComment($historyComment)
    {
        $this->historyComment = $historyComment;
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
     * @return AbstractGlEntry[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param AbstractGlEntry[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
