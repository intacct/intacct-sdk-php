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
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateJournalEntry extends AbstractGlBatch
{

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
    public function getSourceEntityId()
    {
        return $this->sourceEntityId;
    }

    /**
     * @param string $sourceEntityId
     */
    public function setSourceEntityId($sourceEntityId)
    {
        $this->sourceEntityId = $sourceEntityId;
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
            'journal_symbol' => null,
            'posting_date' => null,
            'reverse_date' => null,
            'description' => null,
            'history_comment' => null,
            'reference_number' => null,
            'source_entity_id' => null,
            'attachments_id' => null,
            'action' => null,
            'custom_fields' => [],
            'entries' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setJournalSymbol($config['journal_symbol']);
        $this->setPostingDate($config['posting_date']);
        $this->setReverseDate($config['reverse_date']);
        $this->setDescription($config['description']);
        $this->setHistoryComment($config['history_comment']);
        $this->setReferenceNumber($config['reference_number']);
        $this->setSourceEntityId($config['source_entity_id']);
        $this->setAttachmentsId($config['attachments_id']);
        $this->setAction($config['action']);
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

        $xml->startElement('create');
        $xml->startElement('GLBATCH');

        $xml->writeElement('JOURNAL', $this->getJournalSymbol(), true);
        $xml->writeElement('BATCH_DATE', $this->getPostingDate(), true);
        $xml->writeElement('REVERSEDATE', $this->getReverseDate());
        $xml->writeElement('BATCH_TITLE', $this->getDescription(), true);
        $xml->writeElement('HISTORY_COMMENT', $this->getHistoryComment());
        $xml->writeElement('REFERENCENO', $this->getReferenceNumber());
        $xml->writeElement('BASELOCATION_NO', $this->getSourceEntityId());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('STATE', $this->getAction());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->startElement('ENTRIES');
        if (count($this->getEntries()) >= 2) {
            foreach ($this->getEntries() as $entry) {
                if ($entry instanceof CreateJournalEntryEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreateJournalEntryEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('Journal Entry "entries" param must have at least 2 entries');
        }
        $xml->endElement(); //ENTRIES

        $xml->endElement(); //GLBATCH
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
