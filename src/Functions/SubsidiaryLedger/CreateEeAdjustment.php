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

class CreateEeAdjustment extends AbstractEeTransaction
{

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
     * @return string
     */
    public function getExpenseAdjustmentNumber()
    {
        return $this->expenseAdjustmentNumber;
    }

    /**
     * @param string $expenseAdjustmentNumber
     */
    public function setExpenseAdjustmentNumber($expenseAdjustmentNumber)
    {
        $this->expenseAdjustmentNumber = $expenseAdjustmentNumber;
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
            'gl_posting_date' => null,
            'employee_id' => null,
            'expense_adjustment_no' => null,
            'expense_report_no' => null,
            'summary_record_no' => null,
            'base_currency' => null,
            'reimbursement_currency' => null,
            'description' => null,
            'attachments_id' => null,
            'entries' => [],
            //'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setTransactionDate($config['transaction_date']);
        $this->setGlPostingDate($config['gl_posting_date']);
        $this->setEmployeeId($config['employee_id']);
        $this->setExpenseAdjustmentNumber($config['expense_adjustment_no']);
        $this->setExpenseReportNumber($config['expense_report_no']);
        $this->setSummaryRecordNo($config['summary_record_no']);
        $this->setBaseCurrency($config['base_currency']);
        $this->setReimbursementCurrency($config['reimbursement_currency']);
        $this->setDescription($config['description']);
        $this->setAttachmentsId($config['attachments_id']);
        $this->setEntries($config['entries']);
        //$this->setCustomFields($config['custom_fields']);
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

        $xml->startElement('create_expenseadjustmentreport');

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
        $xml->writeElement('adjustmentno', $this->getExpenseAdjustmentNumber());
        $xml->writeElement('docnumber', $this->getExpenseReportNumber());
        $xml->writeElement('description', $this->getDescription());
        $xml->writeElement('basecurr', $this->getBaseCurrency());
        $xml->writeElement('currency', $this->getReimbursementCurrency());

        // Current schema does not allow custom fields
        // $this->writeXmlExplicitCustomFields($xml);

        $xml->startElement('expenseadjustments');
        if (count($this->getEntries()) > 0) {
            foreach ($this->getEntries() as $entry) {
                if ($entry instanceof CreateEeAdjustmentEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreateEeAdjustmentEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('EE Adjustment "entries" param must have at least 1 entry');
        }
        $xml->endElement(); //expenseadjustments

        $xml->writeElement('supdocid', $this->getAttachmentsId());

        $xml->endElement(); //create_expenseadjustmentreport

        $xml->endElement(); //function
    }
}
