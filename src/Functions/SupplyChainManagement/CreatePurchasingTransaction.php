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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreatePurchasingTransaction extends AbstractCreateOePoTransaction
{

    /** @var string */
    private $vendorId;

    /** @var string */
    private $vendorDocNumber;

    /** @var string */
    private $returnToContactName;

    /** @var string */
    private $payToContactName;

    /** @var array */
    protected $entries;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'vendor_id' => null,
            'vendor_document_number' => null,
            'return_to_contact_name' => null,
            'pay_to_contact_name' => null,
            'entries' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->vendorId = $config['vendor_id'];
        $this->vendorDocNumber = $config['vendor_document_number'];
        $this->returnToContactName = $config['return_to_contact_name'];
        $this->payToContactName = $config['pay_to_contact_name'];
        $this->entries = $config['entries'];
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

        $xml->startElement('create_potransaction');

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
        $xml->writeElement('vendorid', $this->vendorId, true);
        $xml->writeElement('documentno', $this->documentNumber);

        $xml->writeElement('referenceno', $this->referenceNumber);
        $xml->writeElement('vendordocno', $this->vendorDocNumber);
        $xml->writeElement('termname', $this->paymentTerm);

        if ($this->dueDate) {
            $xml->startElement('datedue');
            $xml->writeDateSplitElements($this->dueDate, true);
            $xml->endElement(); //datedue
        } else {
            throw new InvalidArgumentException('Missing required "due_date" param');
        }

        $xml->writeElement('message', $this->message);
        $xml->writeElement('shippingmethod', $this->shippingMethod);

        $xml->startElement('returnto');
        $xml->writeElement('contactname', $this->returnToContactName, true);
        $xml->endElement(); //returnto

        $xml->startElement('payto');
        $xml->writeElement('contactname', $this->payToContactName, true);
        $xml->endElement(); //payto

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

        $this->writeXmlExplicitCustomFields($xml);

        $xml->writeElement('state', $this->state);

        $xml->startElement('potransitems');
        if (count($this->entries) > 0) {
            foreach ($this->entries as $entry) {
                if ($entry instanceof CreatePurchasingTransactionEntry) {
                    $entry->writeXml($xml);
                } elseif (is_array($entry)) {
                    $entry = new CreatePurchasingTransactionEntry($entry);

                    $entry->writeXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"entries" param must have at least 1 entry');
        }
        $xml->endElement(); //potransitems

        $this->getSubtotalEntries($xml);

        $xml->endElement(); //create_potransaction

        $xml->endElement(); //function
    }
}
