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
use Intacct\Functions\Traits\InvoiceDateTrait;
use Intacct\Functions\Traits\ExchangeRateInfoTrait;
use Intacct\Functions\Traits\GlPostingDateTrait;
use Intacct\Functions\Traits\CustomerIdTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateArAdjustment implements FunctionInterface
{

    use ControlIdTrait;
    use ExchangeRateInfoTrait;
    use CustomerIdTrait;
    use InvoiceDateTrait;
    use GlPostingDateTrait;

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
    private $adjustmentNumber;
    
    /**
     *
     * @var string
     */
    private $invoiceNumber;

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
     * @var array
     */
    private $arAdjustmentEntries;

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
            'batch_key' => null,
            'adjustment_number' => null,
            'action' => null,
            'invoice_number' => null,
            'description' => null,
            'external_id' => null,
            'base_currency' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'do_not_post_to_gl' => null,
            'ar_adjustment_entries' => [],
        ];
        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);

        $this->setCustomerId($config['customer_id']);
        $this->setInvoiceDate($config['when_created']);
        $this->setGlPostingDate($config['when_posted']);
        $this->batchKey = $config['batch_key'];
        $this->adjustmentNumber = $config['adjustment_number'];
        $this->action = $config['action'];
        $this->invoiceNumber = $config['invoice_number'];
        $this->description = $config['description'];
        $this->externalId = $config['external_id'];
        $this->setBaseCurrency($config['base_currency']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->doNotPostToGL = $config['do_not_post_to_gl'];
        $this->arAdjustmentEntries = $config['ar_adjustment_entries'];
        
    }

    /**
     * @param XMLWriter $xml
     * @throws InvalidArgumentException
     */
    private function getArAdjustmentEntriesXml(XMLWriter &$xml)
    {
        $xml->startElement('aradjustmentitems');

        if (count($this->arAdjustmentEntries) > 0) {
            foreach ($this->arAdjustmentEntries as $arAdjustmentEntry) {
                if ($arAdjustmentEntry instanceof CreateArAdjustmentEntry) {
                    $arAdjustmentEntry->getXml($xml);
                } else if (is_array($arAdjustmentEntry)) {
                    $arAdjustmentEntry = new CreateArAdjustmentEntry($arAdjustmentEntry);

                    $arAdjustmentEntry->getXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"ar_adjustment_entries" param must have at least 1 entry');
        }

        $xml->endElement(); //aradjustmentitems
    }

    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId);

        $xml->startElement('create_aradjustment');

        $xml->writeElement('customerid', $this->customerId, true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->getInvoiceDate());
        $xml->endElement(); //datecreated

        if ($this->glPostingDate) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->glPostingDate, true);
            $xml->endElement(); //dateposted
        }

        $xml->writeElement('batchkey', $this->batchKey);
        $xml->writeElement('adjustmentno', $this->adjustmentNumber);
        $xml->writeElement('action', $this->action);
        $xml->writeElement('invoiceno', $this->invoiceNumber);
        $xml->writeElement('description', $this->description);
        $xml->writeElement('externalid', $this->externalId);

        $this->getExchangeRateInfoXml($xml);

        $xml->writeElement('nogl', $this->doNotPostToGL);
        
        $this->getArAdjustmentEntriesXml($xml);

        $xml->endElement(); //create_aradjustment

        $xml->endElement(); //function
    }

}
