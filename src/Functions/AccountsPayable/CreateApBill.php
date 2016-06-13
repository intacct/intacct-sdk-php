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

use Intacct\Fields\Date;
use Intacct\Functions\ControlIdTrait;
use Intacct\Functions\FunctionInterface;
use Intacct\Functions\Traits\BillDateTrait;
use Intacct\Functions\Traits\DueDateTrait;
use Intacct\Functions\Traits\ExchangeRateTypeTrait;
use Intacct\Functions\Traits\GlPostingDateTrait;
use Intacct\Functions\Traits\VendorIdTrait;
use Intacct\Xml\XMLWriter;

class CreateApBill implements FunctionInterface
{

    use ControlIdTrait;
    use ExchangeRateTypeTrait;
    use VendorIdTrait;
    use BillDateTrait;
    use GlPostingDateTrait;
    use DueDateTrait;
    
    /**
     *
     * @var string
     */
    private $paymentTerm;
    
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
    private $payToContactKey;
    
    /**
     *
     * @var string
     */
    private $returnToContactKey;
    
    /**
     *
     * @var string
     */
    private $baseCurrency;
    
    /**
     *
     * @var string
     */
    private $transactionCurrency;
    
    /**
     *
     * @var Date
     */
    private $exchangeRateDate;
    
    /**
     *
     * @var float
     */
    private $exchangeRateValue;
    
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
    private $customFields;
    
    /**
     *
     * @var array
     */
    private $entries;

    /**
     * 
     * @param array $params my params
     * @param string $functionControlId my function
     */
    public function __construct(array $params = [], $functionControlId = null)
    {
        $defaults = [
            'VENDORID' => null,
            'WHENCREATED' => null,
            'WHENPOSTED' => null,
        ];
        $config = array_merge($defaults, $params);

        $this->setControlId($functionControlId);

        $this->setVendorId($config['VENDORID']);
        $this->setBillDate($config['WHENCREATED']);
        $this->setGlPostingDate($config['WHENPOSTED']);

        $this->setDueDate($config['DUEDATE']);
        
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
        $xml->writeElement(
            'datecreated',
            $xml->writeDateSplitElements($this->billDate),
            true
        );
        if ($this->glPostingDate) {
            $xml->writeElement(
                'dateposted',
                $xml->writeDateSplitElements($this->glPostingDate),
                true
            );
        }
        if ($this->dueDate) {
            $xml->writeElement(
                'datedue',
                $xml->writeDateSplitElements($this->dueDate),
                true
            );
        }
        $xml->writeElement('termname', $this->paymentTerm, true);
        $xml->writeElement('batchkey', $this->batchKey);
        $xml->writeElement('billno', $this->billNumber);
        $xml->writeElement('ponumber', $this->referenceNumber);
        $xml->writeElement('onhold', $this->onHold);
        $xml->writeElement('description', $this->description);
        $xml->writeElement('externalid', $this->externalId);
        $xml->writeElement(
            'payto',
            $xml->writeElement(
                'contactname', $this->payToContactKey
            )
            //TODO: support contact creation
        );
        $xml->writeElement(
            'returnto',
            $xml->writeElement(
                'contactname', $this->returnToContactKey
            )
            //TODO: support contact creation
        );
        $xml->writeElement('basecurr', $this->baseCurrency);
        $xml->writeElement('currency', $this->transactionCurrency);
        if ($this->exchangeRateDate) {
            $xml->writeElement(
                'exchratedate',
                $xml->writeDateSplitElements($this->exchangeRateDate),
                true
            );
        }
        if ($this->exchangeRateType) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType());
        } else if ($this->exchangeRateValue) {
            $xml->writeElement('exchrate', $this->exchangeRateValue);
        } else if ($this->baseCurrency || $this->transactionCurrency) {
            $xml->writeElement('exchratetype', $this->exchangeRateType, true);
        }
        $xml->writeElement('nogl', $this->doNotPostToGL);
        $xml->writeElement('supdocid', $this->attachmentsId);

        if (count($this->customFields) > 0) {
            $xml->startElement('customfields');
            foreach ($this->customFields as $customFieldName => $customFieldValue) {
                $xml->startElement('customfield');
                $xml->writeElement('customfieldname', $customFieldName, true);
                $xml->writeElement('customfieldvalue', $customFieldValue, true);
                $xml->endElement(); //customfield
            }
            $xml->endElement(); //customfields
        }
        
        $xml->startElement('billitems');
        foreach ($this->entries as $entry) {
            $xml->startElement('lineitem');
            if ($entry->accountLabel) {
                $xml->writeElement('accountlabel', $entry->accountLabel);
            } else {
                $xml->writeElement('glaccountno', $entry->glAccountNo);
            }
            $xml->writeElement('amount', $entry->transactionAmount);
            $xml->writeElement('memo', $entry->memo);
            $xml->writeElement('locationid', $entry->locationId);
            $xml->writeElement('departmentid', $entry->departmentId);
            $xml->writeElement('item1099', $entry->form1099);
            
            //TODO finish this
            
            $xml->endElement(); //lineitem
        }
        $xml->endElement(); //billitems

        $xml->endElement(); //create_bill

        $xml->endElement(); //function
    }

}
