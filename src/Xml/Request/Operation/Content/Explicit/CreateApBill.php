<?php

/*
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

namespace Intacct\Xml\Request\Operation\Content\Explicit;

use Intacct\Xml\Request\Operation\Content\FunctionInterface;
use Intacct\Xml\Request\Operation\Content\XMLHelperTrait;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

/**
 * @todo this is just to test stuff
 */
class CreateApBill implements FunctionInterface
{
    
    use XMLHelperTrait;

    /**
     *
     * @var string
     */
    private $vendorId;
    
    /**
     *
     * @var DateTime
     */
    private $billDate;
    
    /**
     *
     * @var DateTime
     */
    private $glPostingDate;
    
    /**
     *
     * @var DateTime
     */
    private $dueDate;
    
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
     * @var DateTime
     */
    private $exchangeRateDate;
    
    /**
     *
     * @var string
     */
    private $exchangeRateType;
    
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
     * @param array $params
     */
    public function __construct(array $params)
    {
        $defaults = [
            'vendor_id' => null,
            'bill_date' => null,
            'gl_posting_date' => null,
        ];
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

        $xml->writeElement('vendorid', $this->vendorId);
        $xml->writeElement('datecreated', $this->dateSplitToXml($this->billDate, $xml));
        $xml->writeElement('dateposted', $this->dateSplitToXml($this->glPostingDate, $xml));
        $xml->writeElement('datedue', $this->dateSplitToXml($this->dueDate, $xml));
        $xml->writeElement('termname', $this->paymentTerm);
        $xml->writeElement('batchkey', $this->batchKey);
        $xml->writeElement('billno', $this->billNumber);
        $xml->writeElement('ponumber', $this->referenceNumber);
        $xml->writeElement('onhold', $this->onHold);
        $xml->writeElement('description', $this->description);
        $xml->writeElement('externalid', $this->externalId);
        //TODO payto
        //TODO returnto
        $xml->writeElement('basecurr', $this->baseCurrency);
        $xml->writeElement('currency', $this->transactionCurrency);
        $xml->writeElement('exchratedate', $this->dateSplitToXml($this->exchangeRateDate, $xml));
        $xml->writeElement('exchratetype', $this->exchangeRateType);
        $xml->writeElement('exchrate', $this->exchangeRateValue);
        $xml->writeElement('nogl', $this->doNotPostToGL);
        
        if (count($this->customFields) > 0) {
            $xml->startElement('customfields');
            foreach ($this->customFields as $customFieldName => $customFieldValue) {
                $xml->startElement('customfield');
                $xml->writeElement('customfieldname', $customFieldName);
                $xml->writeElement('customfieldvalue', $customFieldValue);
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
            $xml->endElement(); //lineitem
        }
        $xml->endElement(); //billitems

        $xml->endElement(); //create_bill

        $xml->endElement(); //function
    }

}
