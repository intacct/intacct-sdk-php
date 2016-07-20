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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\BillToTrait;
use Intacct\Functions\Traits\InvoiceDateTrait;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DueDateTrait;
use Intacct\Functions\Traits\ExchangeRateInfoTrait;
use Intacct\Functions\Traits\GlPostingDateTrait;
use Intacct\Functions\Traits\CustomerIdTrait;
use Intacct\Functions\Traits\ShipToTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateArInvoice implements FunctionInterface
{

    use ControlIdTrait;
    use ExchangeRateInfoTrait;
    use CustomerIdTrait;
    use InvoiceDateTrait;
    use GlPostingDateTrait;
    use DueDateTrait;
    use CustomFieldsTrait;
    use ShipToTrait;
    use BillToTrait;
    
    /**
     *
     * @var string
     */
    private $paymentTerm;

    /**
     * @var string
     */
    private $action;
    
    /**
     *
     * @var string
     */
    private $batchKey;
    
    /**
     *
     * @var string
     */
    private $invoiceNumber;
    
    /**
     *
     * @var string
     */
    private $referenceNumber;
    
    /**
     *
     * @var bool
     */
    private $onHold;
    
    /**
     *
     * @var string
     */
    private $description;
    
    /**
     *
     * @var string
     */
    private $externalId;

    /**
     *
     * @var bool
     */
    private $doNotPostToGL;

    /**
     *
     * @var string
     */
    private $attachmentsId;

    /**
     *
     * @var array
     */
    private $arInvoiceEntries;

    /**
     * 
     * @param array $params my params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'customer_id' => null,
            'when_created' => null,
            'when_posted' => null,
            'due_date' => null,
            'payment_term' => null,
            'batch_key' => null,
            'action' => null,
            'invoice_number' => null,
            'reference_number' => null,
            'on_hold' => null,
            'description' => null,
            'external_id' => null,
            'bill_to_contact_name' => null,
            'ship_to_contact_name' => null,
            'base_currency' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'do_not_post_to_gl' => null,
            'attachments_id' => null,
            'custom_fields' => [],
            'ar_invoice_entries' => [],
        ];
        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);

        $this->setCustomerId($config['customer_id']);
        $this->setInvoiceDate($config['when_created']);
        $this->setGlPostingDate($config['when_posted']);
        $this->setDueDate($config['due_date']);
        $this->paymentTerm = $config['payment_term'];
        $this->action = $config['action'];
        $this->invoiceNumber = $config['invoice_number'];
        $this->batchKey = $config['batch_key'];
        $this->referenceNumber = $config['reference_number'];
        $this->onHold = $config['on_hold'];
        $this->description = $config['description'];
        $this->externalId = $config['external_id'];
        $this->setBillToContactName($config['bill_to_contact_name']);
        $this->setShipToContactName($config['ship_to_contact_name']);
        $this->setBaseCurrency($config['base_currency']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->doNotPostToGL = $config['do_not_post_to_gl'];
        $this->attachmentsId = $config['attachments_id'];
        $this->setCustomFields($config['custom_fields']);
        $this->arInvoiceEntries = $config['ar_invoice_entries'];
        
    }

    /**
     * @param XMLWriter $xml
     */
    private function getTermInfoXml(XMLWriter &$xml)
    {
        if ($this->dueDate) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->dueDate, true);
            $xml->endElement(); // datedue

            $xml->writeElement('termname', $this->paymentTerm);
        } else {
            $xml->writeElement('termname', $this->paymentTerm, true);
        }
    }

    /**
     * @param XMLWriter $xml
     * @throws InvalidArgumentException
     */
    private function getArInvoiceEntriesXml(XMLWriter &$xml)
    {
        $xml->startElement('invoiceitems');

        if (count($this->arInvoiceEntries) > 0) {
            foreach ($this->arInvoiceEntries as $arInvoiceEntry) {
                if ($arInvoiceEntry instanceof CreateArInvoiceEntry) {
                    $arInvoiceEntry->getXml($xml);
                } else if (is_array($arInvoiceEntry)) {
                    $arInvoiceEntry = new CreateArInvoiceEntry($arInvoiceEntry);

                    $arInvoiceEntry->getXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"ar_invoice_entries" param must have at least 1 entry');
        }

        $xml->endElement(); //invoiceitems
    }

    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId);

        $xml->startElement('create_invoice');

        $xml->writeElement('customerid', $this->customerId, true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getInvoiceDate());
        $xml->endElement(); //datecreated

        if ($this->glPostingDate) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->glPostingDate, true);
            $xml->endElement(); //dateposted
        }

        $this->getTermInfoXml($xml);

        $xml->writeElement('action', $this->action);
        $xml->writeElement('batchkey', $this->batchKey);
        $xml->writeElement('invoiceno', $this->invoiceNumber);
        $xml->writeElement('ponumber', $this->referenceNumber);
        $xml->writeElement('onhold', $this->onHold);
        $xml->writeElement('description', $this->description);
        $xml->writeElement('externalid', $this->externalId);

        $this->getBillToContactNameXml($xml);

        $this->getShipToContactNameXml($xml);

        $this->getExchangeRateInfoXml($xml);

        $xml->writeElement('nogl', $this->doNotPostToGL);
        $xml->writeElement('supdocid', $this->attachmentsId);

        $this->getCustomFieldsXml($xml);
        
        $this->getArInvoiceEntriesXml($xml);

        $xml->endElement(); //create_invoice

        $xml->endElement(); //function
    }

}
