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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\BillDateTrait;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Functions\Traits\DueDateTrait;
use Intacct\Functions\Traits\ExchangeRateInfoTrait;
use Intacct\Functions\Traits\GlPostingDateTrait;
use Intacct\Functions\Traits\VendorIdTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateApBill implements FunctionInterface
{

    use ControlIdTrait;
    use ExchangeRateInfoTrait;
    use VendorIdTrait;
    use BillDateTrait;
    use GlPostingDateTrait;
    use DueDateTrait;
    use CustomFieldsTrait;
    
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
    private $billNumber;
    
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
     * @var string
     */
    private $payToContactName;
    
    /**
     *
     * @var string
     */
    private $returnToContactName;

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
    private $apBillEntries;

    /**
     * 
     * @param array $params my params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'vendor_id' => null,
            'when_created' => null,
            'when_posted' => null,
            'due_date' => null,
            'payment_term' => null,
            'action' => null,
            'batch_key' => null,
            'bill_number' => null,
            'reference_number' => null,
            'on_hold' => null,
            'description' => null,
            'external_id' => null,
            'pay_to_contact_name' => null,
            'return_to_contact_name' => null,
            'base_currency' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'do_not_post_to_gl' => null,
            'attachments_id' => null,
            'custom_fields' => [],
            'ap_bill_entries' => [],
        ];
        $config = array_merge($defaults, $params);

        $this->setControlId($config['control_id']);

        $this->setVendorId($config['vendor_id']);
        $this->setBillDate($config['when_created']);
        $this->setGlPostingDate($config['when_posted']);
        $this->setDueDate($config['due_date']);
        $this->paymentTerm = $config['payment_term'];
        $this->action = $config['action'];
        $this->batchKey = $config['batch_key'];
        $this->billNumber = $config['bill_number'];
        $this->referenceNumber = $config['reference_number'];
        $this->onHold = $config['on_hold'];
        $this->description = $config['description'];
        $this->externalId = $config['external_id'];
        $this->payToContactName = $config['pay_to_contact_name'];
        $this->returnToContactName = $config['return_to_contact_name'];
        $this->setBaseCurrency($config['base_currency']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->doNotPostToGL = $config['do_not_post_to_gl'];
        $this->attachmentsId = $config['attachments_id'];
        $this->setCustomFields($config['custom_fields']);
        $this->apBillEntries = $config['ap_bill_entries'];
        
    }

    /**
     * @param XMLWriter $xml
     */
    private function getTermInfoXml(XMLWriter $xml)
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
     */
    private function getPayToContactNameXml(XMLWriter $xml)
    {
        if (is_null($this->payToContactName) == false) {
            $xml->startElement('payto');
            $xml->writeElement('contactname', $this->payToContactName);
            $xml->endElement(); //payto
        }
    }

    /**
     * @param XMLWriter $xml
     */
    private function getReturnToContactNameXml(XMLWriter $xml)
    {
        if (is_null($this->returnToContactName) == false) {
            $xml->startElement('returnto');
            $xml->writeElement('contactname', $this->returnToContactName);
            $xml->endElement(); //returnto
        }
    }

    /**
     * @param XMLWriter $xml
     * @throws InvalidArgumentException
     */
    private function getApBillEntriesXml(XMLWriter $xml)
    {
        $xml->startElement('billitems');

        if (count($this->apBillEntries) > 0) {
            foreach ($this->apBillEntries as $apBillEntry) {
                if ($apBillEntry instanceof CreateApBillEntry) {
                    $apBillEntry->getXml($xml);
                } else if (is_array($apBillEntry)) {
                    $apBillEntry = new CreateApBillEntry($apBillEntry);

                    $apBillEntry->getXml($xml);
                }
            }
        } else {
            throw new InvalidArgumentException('"ap_bill_entries" param must have at least 1 entry');
        }

        $xml->endElement(); //billitems
    }

    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId);

        $xml->startElement('create_bill');

        $xml->writeElement('vendorid', $this->vendorId, true);

        $xml->startElement('datecreated');
        $xml->writeDateSplitElements($this->billDate);
        $xml->endElement(); //datecreated

        if ($this->glPostingDate) {
            $xml->startElement('dateposted');
            $xml->writeDateSplitElements($this->glPostingDate, true);
            $xml->endElement(); //dateposted
        }

        $this->getTermInfoXml($xml);

        $xml->writeElement('action', $this->action); // this was missing.  any reason?
        $xml->writeElement('batchkey', $this->batchKey);
        $xml->writeElement('billno', $this->billNumber);
        $xml->writeElement('ponumber', $this->referenceNumber);
        $xml->writeElement('onhold', $this->onHold);
        $xml->writeElement('description', $this->description);
        $xml->writeElement('externalid', $this->externalId);

        $this->getPayToContactNameXml($xml);

        $this->getReturnToContactNameXml($xml);

        $this->getExchangeRateInfoXml($xml);

        $xml->writeElement('nogl', $this->doNotPostToGL);
        $xml->writeElement('supdocid', $this->attachmentsId);

        $this->getCustomFieldsXml($xml);
        
        $this->getApBillEntriesXml($xml);

        $xml->endElement(); //create_bill

        $xml->endElement(); //function
    }

}
