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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Fields\Date;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractGlBatch extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $journalSymbol;

    /** @var Date */
    protected $postingDate;

    /** @var Date */
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

    /** @var array */
    protected $lines;

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
     * @return Date
     */
    public function getPostingDate()
    {
        return $this->postingDate;
    }

    /**
     * @param Date $postingDate
     */
    public function setPostingDate($postingDate)
    {
        $this->postingDate = $postingDate;
    }

    /**
     * @return Date
     */
    public function getReverseDate()
    {
        return $this->reverseDate;
    }

    /**
     * @param Date $reverseDate
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
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param array $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
