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

namespace Intacct\Functions\SupplyChainManagement;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateOrderEntryTransaction extends AbstractCreateOePoTransaction
{

    /** @var string */
    private $customerId;

    /** @var Date */
    private $originalDocumentDate;

    /** @var string */
    private $shipToContactName;

    /** @var string */
    private $billToContactName;

    /** @var string */
    private $vsoePriceList;

    /** @var string */
    private $projectId;

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
            'customer_id' => null,
            'original_document_date' => null,
            'ship_to_contact_name' => null,
            'bill_to_contact_name' => null,
            'vsoe_price_list' => null,
            'project_id' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->customerId = $config['customer_id'];
        $this->originalDocumentDate = $config['original_document_date'];
        $this->shipToContactName = $config['ship_to_contact_name'];
        $this->billToContactName = $config['bill_to_contact_name'];
        $this->vsoePriceList = $config['vsoe_price_list'];
        $this->projectId = $config['project_id'];
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_sotransaction');

        $xml->writeElement('transactiontype', $this->transactionDefinition, true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->transactionDate, true);
        $xml->endElement(); //datecreated

        if ($this->glPostingDate) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->glPostingDate, true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('createdfrom', $this->createdFrom);
        $xml->writeElement('customerid', $this->customerId, true);
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
            $xml->writeDateSplitElements($this->dueDate, true);
            $xml->endElement(); //datedue
        }

        $xml->writeElement('message', $this->message);
        $xml->writeElement('shippingmethod', $this->shippingMethod);
        if ($this->shipToContactName) {
            $xml->startElement('shipto');
            $xml->writeElement('contactname', $this->shipToContactName, true);
            $xml->endElement();
        }
        if ($this->billToContactName) {
            $xml->startElement('billto');
            $xml->writeElement('contactname', $this->billToContactName, true);
            $xml->endElement();
        }
        $xml->writeElement('supdocid', $this->attachmentsId);
        $xml->writeElement('externalid', $this->externalId);

        $xml->writeElement('basecurr', $this->baseCurrency);
        $xml->writeElement('currency', $this->transactionCurrency);

        if ($this->exchangeRateDate) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->exchangeRateDate, true);
            $xml->endElement();
        }

        if ($this->exchangeRateType) {
            $xml->writeElement('exchratetype', $this->exchangeRateType);
        } elseif ($this->exchangeRateValue) {
            $xml->writeElement('exchrate', $this->exchangeRateValue);
        } elseif ($this->baseCurrency || $this->transactionCurrency) {
            $xml->writeElement('exchratetype', $this->exchangeRateType, true);
        }

        $xml->writeElement('vsoepricelist', $this->vsoePriceList);

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('state', $this->state);
        $xml->writeElement('projectid', $this->projectId);

        $xml->startElement('sotransitems');
        if (count($this->entries) > 0) {
            foreach ($this->entries as $entry) {
                if ($entry instanceof CreateOrderEntryTransactionEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreateOrderEntryTransactionEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"entries" param must have at least 1 entry');
        }
        $xml->endElement(); //sotransitems

        $this->getSubtotalEntries($xml);

        $xml->endElement(); //create_sotransaction

        $xml->endElement(); //function
    }
}
