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

namespace Intacct\Functions\Projects;


use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

class TimesheetApprove extends AbstractFunction {

    /** @var int|string */
    public $recordNo;

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
    public function setRecordNo($recordNo): void
    {
        $this->recordNo = $recordNo;
    }

    /** @var array */
    public $lineRecordNo;

    /**
     * @return array
     */
    public function getLineRecordNo(): array
    {
        return $this->lineRecordNo;
    }

    /**
     * @param array $lineRecordNo
     */
    public function setLineRecordNo(array $lineRecordNo): void
    {
        $this->lineRecordNo = $lineRecordNo;
    }

    /** @var string */
    public $approvedBy;

    /**
     * @return string
     */
    public function getApprovedBy(): string
    {
        return $this->approvedBy;
    }

    /**
     * @param string $approvedBy
     */
    public function setApprovedBy(string $approvedBy): void
    {
        $this->approvedBy = $approvedBy;
    }

    /** @var string */
    public $comment;

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Get keys for XML
     *
     * @return string
     */
    private function writeEntryKeys()
    {
        if (count($this->lineRecordNo) > 0) {
            $fields = implode(',', $this->lineRecordNo);
        } else {
            $fields = '';
        }

        return $fields;
    }

    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId, true);
        $xml->startElement('approve');
        $xml->startElement('TIMESHEET');

        $xml->writeElement('RECORDNO', $this->recordNo, true);
        $xml->writeElement('ENTRYKEYS', $this->writeEntryKeys(), true);
        $xml->writeElement('APPROVEDBY', $this->approvedBy, true);
        $xml->writeElement('COMMENT', $this->comment, true);

        $xml->endElement(); // TIMESHEET
        $xml->endElement(); // approve
        $xml->endElement(); // function
    }
}