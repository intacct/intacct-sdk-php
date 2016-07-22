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

namespace Intacct\Functions\Purchasing;

use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\PayToTrait;
use Intacct\Functions\Traits\VendorIdTrait;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DueDateTrait;
use Intacct\Functions\Traits\ExchangeRateInfoTrait;
use Intacct\Functions\Traits\GlPostingDateTrait;
use Intacct\Functions\Traits\ReturnToTrait;
use Intacct\Functions\Traits\TransactionDateTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;
use Intacct\Functions\CreateSubtotalEntry;

class CreatePurchasingTransaction implements FunctionInterface
{

    use ControlIdTrait;
    use VendorIdTrait;
    use TransactionDateTrait;
    use GlPostingDateTrait;
    use DueDateTrait;
    use PayToTrait;
    use ReturnToTrait;
    use ExchangeRateInfoTrait;
    use CustomFieldsTrait;

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
     * @var string
     */
    private $referenceNumber;

    /**
     * @var string
     */
    private $vendorDocNumber;

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
    private $state;

    /**
     * @var array
     */
    private $purchasingTransactionEntries;

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
            'transaction_date' => null,
            'gl_posting_date' => null,
            'created_from' => null,
            'vendor_id' => null,
            'document_number' => null,
            'reference_number' => null,
            'vendor_document_number' => null,
            'payment_term' => null,
            'due_date' => null,
            'message' => null,
            'shipping_method' => null,
            'return_to_contact_name' => null,
            'pay_to_contact_name' => null,
            'attachments_id' => null,
            'external_id' => null,
            'base_currency' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'custom_fields' => [],
            'state' => null,
            'purchasing_transaction_entries' => [],
            'subtotals' => []
        ];
        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);

        $this->transactionDefinition = $config['transaction_definition'];
        $this->setTransactionDate($config['transaction_date']);
        $this->setGlPostingDate($config['gl_posting_date']);
        $this->createdFrom = $config['created_from'];
        $this->setVendorId($config['vendor_id']);
        $this->documentNumber = $config['document_number'];
        $this->referenceNumber = $config['reference_number'];
        $this->vendorDocNumber = $config['vendor_document_number'];
        $this->paymentTerm = $config['payment_term'];
        $this->setDueDate($config['due_date']);
        $this->message = $config['message'];
        $this->shippingMethod = $config['shipping_method'];
        $this->setReturnToContactName($config['return_to_contact_name']);
        $this->setPayToContactName($config['pay_to_contact_name']);
        $this->attachmentsId = $config['attachments_id'];
        $this->externalId = $config['external_id'];
        $this->setBaseCurrency($config['base_currency']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->setCustomFields($config['custom_fields']);
        $this->state = $config['state'];
        $this->purchasingTransactionEntries = $config['purchasing_transaction_entries'];
        $this->subtotalsEntries = $config['subtotals'];
    }

    /**
     * @param XMLWriter $xml
     */
    private function getPurchasingTransactionEntries(XMLWriter &$xml)
    {
        $xml->startElement('potransitems');

        if (count($this->purchasingTransactionEntries) > 0) {
            foreach ($this->purchasingTransactionEntries as $purchasingTransactionEntry) {
                if ($purchasingTransactionEntry instanceof CreatePurchasingTransactionEntry) {
                    $purchasingTransactionEntry->getXml($xml);
                } else if (is_array($purchasingTransactionEntry)) {
                    $purchasingTransactionEntry = new CreatePurchasingTransactionEntry($purchasingTransactionEntry);

                    $purchasingTransactionEntry->getXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"purchasing_transaction_entries" param must have at least 1 entry');
        }

        $xml->endElement(); //potransitems
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
                } else if (is_array($subtotalEntry)) {
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

        $xml->startElement('create_potransaction');

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
        $xml->writeElement('vendorid', $this->getVendorId(), true);
        $xml->writeElement('documentno', $this->documentNumber);

        $xml->writeElement('referenceno', $this->referenceNumber);
        $xml->writeElement('vendordocno', $this->vendorDocNumber);
        $xml->writeElement('termname', $this->paymentTerm);

        if (is_null($this->getDueDate()) == false) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->getDueDate(), true);
            $xml->endElement(); //datedue
        } else {
            throw new InvalidArgumentException('Missing required "due_date" param');
        }

        $xml->writeElement('message', $this->message);
        $xml->writeElement('shippingmethod', $this->shippingMethod);

        $xml->startElement('returnto');
        $xml->writeElement('contactname', $this->getReturnToContactName(), true);
        $xml->endElement(); //returnto

        $xml->startElement('payto');
        $xml->writeElement('contactname', $this->getPayToContactName(), true);
        $xml->endElement(); //payto

        $xml->writeElement('supdocid', $this->attachmentsId);
        $xml->writeElement('externalid', $this->externalId);

        $this->getExchangeRateInfoXml($xml);

        $this->getCustomFieldsXml($xml);

        $xml->writeElement('state', $this->state);

        $this->getPurchasingTransactionEntries($xml);

        $this->getSubtotalEntries($xml);

        $xml->endElement(); //create_potransaction

        $xml->endElement(); //function
    }
}