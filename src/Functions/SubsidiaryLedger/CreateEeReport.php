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
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateEeReport extends AbstractEeTransaction
{

    use CustomFieldsTrait;

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
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return string
     */
    public function getExpenseReportNumber()
    {
        return $this->expenseReportNumber;
    }

    /**
     * @param string $expenseReportNumber
     */
    public function setExpenseReportNumber($expenseReportNumber)
    {
        $this->expenseReportNumber = $expenseReportNumber;
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
     * @return int|string
     */
    public function getSummaryRecordNo()
    {
        return $this->summaryRecordNo;
    }

    /**
     * @param int|string $summaryRecordNo
     */
    public function setSummaryRecordNo($summaryRecordNo)
    {
        $this->summaryRecordNo = $summaryRecordNo;
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
    public function getReimbursementCurrency()
    {
        return $this->reimbursementCurrency;
    }

    /**
     * @param string $reimbursementCurrency
     */
    public function setReimbursementCurrency($reimbursementCurrency)
    {
        $this->reimbursementCurrency = $reimbursementCurrency;
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
    public function getReasonForExpense()
    {
        return $this->reasonForExpense;
    }

    /**
     * @param string $reasonForExpense
     */
    public function setReasonForExpense($reasonForExpense)
    {
        $this->reasonForExpense = $reasonForExpense;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
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
            'transaction_date' => null,
            'employee_id' => null,
            'expense_report_no' => null,
            'gl_posting_date' => null,
            'summary_record_no' => null,
            'external_id' => null,
            'action' => null,
            'base_currency' => null,
            'reimbursement_currency' => null,
            'attachments_id' => null,
            'reason_for_expense' => null,
            'memo' => null,
            'entries' => [],
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setTransactionDate($config['transaction_date']);
        $this->setEmployeeId($config['employee_id']);
        $this->setExpenseReportNumber($config['expense_report_no']);
        $this->setGlPostingDate($config['gl_posting_date']);
        $this->setSummaryRecordNo($config['summary_record_no']);
        $this->setExternalId($config['external_id']);
        $this->setAction($config['action']);
        $this->setBaseCurrency($config['base_currency']);
        $this->setReimbursementCurrency($config['reimbursement_currency']);
        $this->setAttachmentsId($config['attachments_id']);
        $this->setReasonForExpense($config['reason_for_expense']);
        $this->setMemo($config['memo']);
        $this->setEntries($config['entries']);
        $this->setCustomFields($config['custom_fields']);
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

        $xml->startElement('create_expensereport');

        $xml->writeElement('employeeid', $this->getEmployeeId(), true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate());
        $xml->endElement(); //datecreated

        if ($this->getGlPostingDate()) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->getGlPostingDate(), true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('batchkey', $this->getSummaryRecordNo());
        $xml->writeElement('expensereportno', $this->getExpenseReportNumber());
        $xml->writeElement('state', $this->getAction());
        $xml->writeElement('description', $this->getReasonForExpense());
        $xml->writeElement('memo', $this->getMemo());
        $xml->writeElement('externalid', $this->getExternalId());
        $xml->writeElement('basecurr', $this->getBaseCurrency());
        $xml->writeElement('currency', $this->getReimbursementCurrency());

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('supdocid', $this->getAttachmentsId());

        $xml->startElement('expenses');
        if (count($this->getEntries()) > 0) {
            foreach ($this->getEntries() as $entry) {
                if ($entry instanceof CreateEeReportEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreateEeReportEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('EE Report "entries" param must have at least 1 entry');
        }
        $xml->endElement(); //expenses

        $xml->endElement(); //create_expensereport

        $xml->endElement(); //function
    }
}
