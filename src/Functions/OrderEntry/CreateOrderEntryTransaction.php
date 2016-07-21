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

namespace Intacct\Functions\OrderEntry;

use Intacct\Fields\Date;
use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\BillToTrait;
use Intacct\Functions\Traits\CustomerIdTrait;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DueDateTrait;
use Intacct\Functions\Traits\ExchangeRateInfoTrait;
use Intacct\Functions\Traits\GlPostingDateTrait;
use Intacct\Functions\Traits\ProjectIdTrait;
use Intacct\Functions\Traits\ShipToTrait;
use Intacct\Functions\Traits\TransactionDateTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateOrderEntryTransaction implements FunctionInterface
{
    use ControlIdTrait;
    use CustomerIdTrait;
    use TransactionDateTrait;
    use GlPostingDateTrait;
    use DueDateTrait;
    use ShipToTrait;
    use BillToTrait;
    use ExchangeRateInfoTrait;
    use CustomFieldsTrait;
    use ProjectIdTrait;

    /**
     * @var string
     */
    const STATE_DRAFT = 'Draft';

    /**
     * @var string
     */
    const STATE_PENDING = 'Pending';

    /**
     * @var string
     */
    const STATE_CLOSED = 'Closed';

    /**
     * @var string
     */
    private $transactionDefinition;

    /**
     * @var string
     */
    private $createdFrom;

    /**
     * @var string
     */
    private $documentNumber;

    /**
     * @var Date
     */
    private $originalDocumentDate;

    /**
     * @var string
     */
    private $referenceNumber;

    /**
     * @var string
     */
    private $paymentTerm;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $shippingMethod;

    /**
     * @var string
     */
    private $attachmentsId;

    /**
     * @var string
     */
    private $externalId;

    /**
     * @var string
     */
    private $vsoePriceList;

    /**
     * @var string
     */
    private $state;

    /**
     * @var array
     */
    private $orderEntryTransactionEntries;

    /**
     * @var array
     */
    private $subtotalsEntries;

    /**
     *
     * @param array $params my params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'transaction_definition' => null,
            'when_created' => null,
            'when_posted' => null,
            'created_from' => null,
            'customer_id' => null,
            'document_number' => null,
            'original_document_date' => null,
            'reference_number' => null,
            'payment_term' => null,
            'due_date' => null,
            'message' => null,
            'shipping_method' => null,
            'ship_to_contact_name' => null,
            'bill_to_contact_name' => null,
            'attachments_id' => null,
            'external_id' => null,
            'base_currency' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'vsoe_price_list' => null,
            'custom_fields' => [],
            'state' => null, // Pending
            'project_id' => null,
            'order_entry_transaction_entries' => [],
            'subtotals' => []
        ];
        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);

        $this->transactionDefinition = $config['transaction_definition'];
        $this->setTransactionDate($config['when_created']);
        $this->setGlPostingDate($config['when_posted']);
        $this->createdFrom = $config['created_from'];
        $this->setCustomerId($config['customer_id']);
        $this->documentNumber = $config['document_number'];
        $this->setOriginalDocumentDate($config['original_document_date']);
        $this->referenceNumber = $config['reference_number'];
        $this->paymentTerm = $config['payment_term'];
        $this->setDueDate($config['due_date']);
        $this->message = $config['message'];
        $this->shippingMethod = $config['shipping_method'];
        $this->setShipToContactName($config['ship_to_contact_name']);
        $this->setBillToContactName($config['bill_to_contact_name']);
        $this->attachmentsId = $config['attachments_id'];
        $this->externalId = $config['external_id'];
        $this->setBaseCurrency($config['base_currency']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->vsoePriceList = $config['vsoe_price_list'];
        $this->setCustomFields($config['custom_fields']);
        $this->state = $config['state'];
        $this->setProjectId($config['project_id']);
        $this->orderEntryTransactionEntries = $config['order_entry_transaction_entries'];
        $this->subtotalsEntries = $config['subtotals'];
    }

    /**
     * @param string|Date $originalDocumentDate
     */
    private function setOriginalDocumentDate($originalDocumentDate)
    {
        if (is_null($originalDocumentDate) || $originalDocumentDate instanceof Date) {
            $this->originalDocumentDate = $originalDocumentDate;
        } else {
            $this->originalDocumentDate = new Date($originalDocumentDate);
        }
    }

    /**
     * @param XMLWriter $xml
     */
    private function getOrderEntryTransactionEntries(XMLWriter &$xml)
    {
        $xml->startElement('sotransitems');

        if (count($this->orderEntryTransactionEntries) > 0) {
            foreach ($this->orderEntryTransactionEntries as $orderEntryTransactionEntry) {
                if ($orderEntryTransactionEntry instanceof CreateOrderEntryTransactionEntry) {
                    $orderEntryTransactionEntry->getXml($xml);
                } elseif (is_array($orderEntryTransactionEntry)) {
                    $orderEntryTransactionEntry = new CreateOrderEntryTransactionEntry($orderEntryTransactionEntry);

                    $orderEntryTransactionEntry->getXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"order_entry_transaction_entries" param must have at least 1 entry');
        }

        $xml->endElement(); //sotransitems
    }

    /**
     * @param XMLWriter $xml
     */
    private function getSubtotalEntries(XMLWriter &$xml)
    {
        if (count($this->subtotalsEntries) > 0) {
            $xml->startElement('subtotals');
            foreach ($this->subtotalsEntries as $subtotalEntry) {
                if ($subtotalEntry instanceof CreateSubtotalEntry) {
                    $subtotalEntry->getXml($xml);
                } elseif (is_array($subtotalEntry)) {
                    $subtotalEntry = new CreateSubtotalEntry($subtotalEntry);

                    $subtotalEntry->getXml($xml);
                }
            }
            $xml->endElement(); //subtotals
        }
    }

    /**
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId);

        $xml->startElement('create_sotransaction');

        $xml->writeElement('transactiontype', $this->transactionDefinition, true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getTransactionDate());
        $xml->endElement(); //datecreated

        if ($this->glPostingDate) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->glPostingDate, true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('createdfrom', $this->createdFrom);
        $xml->writeElement('customerid', $this->getCustomerId(), true);
        $xml->writeElement('documentno', $this->documentNumber);

        if ($this->originalDocumentDate) {
            $xml->startElement('origdocdate');
            $xml->writeDateSplitElements($this->originalDocumentDate, true);
            $xml->endElement(); //origdocdate
        }

        $xml->writeElement('referenceno', $this->referenceNumber);
        $xml->writeElement('termname', $this->paymentTerm);

        if ($this->dueDate) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->getDueDate(), true);
            $xml->endElement(); //datedue
        }

        $xml->writeElement('message', $this->message);
        $xml->writeElement('shippingmethod', $this->shippingMethod);

        $this->getShipToContactNameXml($xml);

        $this->getBillToContactNameXml($xml);

        $xml->writeElement('supdocid', $this->attachmentsId);
        $xml->writeElement('externalid', $this->externalId);

        $this->getExchangeRateInfoXml($xml);

        $xml->writeElement('vsoepricelist', $this->vsoePriceList);

        $this->getCustomFieldsXml($xml);

        $xml->writeElement('state', $this->state);
        $xml->writeElement('projectid', $this->getProjectId());

        $this->getOrderEntryTransactionEntries($xml);

        $this->getSubtotalEntries($xml);

        $xml->endElement(); //create_invoice

        $xml->endElement(); //function
    }
}
