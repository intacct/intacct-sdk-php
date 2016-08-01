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

/**
 *
 * @todo add unit tests
 */
class CreateArPayment extends AbstractArPayment
{

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     * @throws InvalidArgumentException
     */
    public function setPaymentMethod($paymentMethod)
    {
        if (!in_array($paymentMethod, static::PAYMENT_METHODS)) {
            throw new InvalidArgumentException('Payment method is not valid');
        }
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string
     */
    public function getBankAccountId()
    {
        return $this->bankAccountId;
    }

    /**
     * @param string $bankAccountId
     */
    public function setBankAccountId($bankAccountId)
    {
        $this->bankAccountId = $bankAccountId;
    }

    /**
     * @return string
     */
    public function getUndepositedFundsGlAccountNo()
    {
        return $this->undepositedFundsGlAccountNo;
    }

    /**
     * @param string $undepositedFundsGlAccountNo
     */
    public function setUndepositedFundsGlAccountNo($undepositedFundsGlAccountNo)
    {
        $this->undepositedFundsGlAccountNo = $undepositedFundsGlAccountNo;
    }

    /**
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
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
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return Date
     */
    public function getReceivedDate()
    {
        return $this->receivedDate;
    }

    /**
     * @param Date $receivedDate
     */
    public function setReceivedDate($receivedDate)
    {
        $this->receivedDate = $receivedDate;
    }

    /**
     * @return float|string
     */
    public function getTransactionPaymentAmount()
    {
        return $this->transactionPaymentAmount;
    }

    /**
     * @param float|string $transactionPaymentAmount
     */
    public function setTransactionPaymentAmount($transactionPaymentAmount)
    {
        $this->transactionPaymentAmount = $transactionPaymentAmount;
    }

    /**
     * @return float|string
     */
    public function getBasePaymentAmount()
    {
        return $this->basePaymentAmount;
    }

    /**
     * @param float|string $basePaymentAmount
     */
    public function setBasePaymentAmount($basePaymentAmount)
    {
        $this->basePaymentAmount = $basePaymentAmount;
    }

    /**
     * @return Date
     */
    public function getExchangeRateDate()
    {
        return $this->exchangeRateDate;
    }

    /**
     * @param Date $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        $this->exchangeRateDate = $exchangeRateDate;
    }

    /**
     * @return float
     */
    public function getExchangeRateValue()
    {
        return $this->exchangeRateValue;
    }

    /**
     * @param float $exchangeRateValue
     */
    public function setExchangeRateValue($exchangeRateValue)
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

    /**
     * @return string
     */
    public function getExchangeRateType()
    {
        return $this->exchangeRateType;
    }

    /**
     * @param string $exchangeRateType
     */
    public function setExchangeRateType($exchangeRateType)
    {
        $this->exchangeRateType = $exchangeRateType;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $authorizationCode
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return string
     */
    public function getOverpaymentLocationId()
    {
        return $this->overpaymentLocationId;
    }

    /**
     * @param string $overpaymentLocationId
     */
    public function setOverpaymentLocationId($overpaymentLocationId)
    {
        $this->overpaymentLocationId = $overpaymentLocationId;
    }

    /**
     * @return string
     */
    public function getOverpaymentDepartmentId()
    {
        return $this->overpaymentDepartmentId;
    }

    /**
     * @param string $overpaymentDepartmentId
     */
    public function setOverpaymentDepartmentId($overpaymentDepartmentId)
    {
        $this->overpaymentDepartmentId = $overpaymentDepartmentId;
    }

    /**
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @param string $referenceNumber
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * @return array
     */
    public function getApplyToTransactions()
    {
        return $this->applyToTransactions;
    }

    /**
     * @param array $applyToTransactions
     */
    public function setApplyToTransactions($applyToTransactions)
    {
        $this->applyToTransactions = $applyToTransactions;
    }

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $payment_method
     *      @var string $bank_account_id
     *      @var string $undep_funds_gl_account_no
     *      @var string $transaction_currency
     *      @var string $base_currency
     *      @var string $customer_id
     *      @var Date $received_date
     *      @var float|string $transaction_payment_amount
     *      @var float|string $base_payment_amount
     *      @var Date $exchange_rate_date
     *      @var string $exchange_rate_type
     *      @var float|string $exchange_rate
     *      @var string $authorization_code
     *      @var string $overpayment_location_id
     *      @var string $overpayment_department_id
     *      @var string $reference_number
     *      @var array $apply_to_transactions
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'payment_method' => null,
            'bank_account_id' => null,
            'undep_funds_gl_account_no' => null,
            'transaction_currency' => null,
            'base_currency' => null,
            'customer_id' => null,
            'received_date' => null,
            'transaction_payment_amount' => null,
            'base_payment_amount' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'authorization_code' => null,
            'overpayment_location_id' => null,
            'overpayment_department_id' => null,
            'reference_number' => null,
            'apply_to_transactions' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setPaymentMethod($config['payment_method']);
        $this->setBankAccountId($config['bank_account_id']);
        $this->setUndepositedFundsGlAccountNo($config['undep_funds_gl_account_no']);
        $this->setTransactionCurrency($config['transaction_currency']);
        $this->setBaseCurrency($config['base_currency']);
        $this->setCustomerId($config['customer_id']);
        $this->setReceivedDate($config['received_date']);
        $this->setTransactionPaymentAmount($config['transaction_payment_amount']);
        $this->setBasePaymentAmount($config['base_payment_amount']);
        $this->setExchangeRateDate($config['exchange_rate_date']);
        $this->setExchangeRateType($config['exchange_rate_type']);
        $this->setExchangeRateValue($config['exchange_rate']);
        $this->setAuthorizationCode($config['authorization_code']);
        $this->setOverpaymentLocationId($config['overpayment_location_id']);
        $this->setOverpaymentDepartmentId($config['overpayment_department_id']);
        $this->setReferenceNumber($config['reference_number']);
        $this->setApplyToTransactions($config['apply_to_transactions']);
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create_arpayment');

        $xml->writeElement('customerid', $this->getCustomerId(), true);
        $xml->writeElement('paymentamount', $this->getTransactionPaymentAmount(), true);
        $xml->writeElement('translatedamount', $this->getBasePaymentAmount());

        if ($this->getUndepositedFundsGlAccountNo()) {
            $xml->writeElement('undepfundsacct', $this->getUndepositedFundsGlAccountNo());
        } elseif ($this->getBankAccountId()) {
            $xml->writeElement('bankaccountid', $this->getBankAccountId());
        }

        $xml->writeElement('refid', $this->getReferenceNumber());
        $xml->writeElement('overpaylocid', $this->getOverpaymentLocationId());
        $xml->writeElement('overpaydeptid', $this->getOverpaymentDepartmentId());

        $xml->startElement('datereceived');
        $xml->writeDateSplitElements($this->getReceivedDate(), true);
        $xml->endElement(); //datereceived

        $xml->writeElement('paymentmethod', $this->getPaymentMethod(), true);

        $xml->writeElement('basecurr', $this->getBaseCurrency());
        $xml->writeElement('currency', $this->getTransactionCurrency());

        if ($this->getExchangeRateDate()) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->getExchangeRateDate(), true);
            $xml->endElement();
        }

        if ($this->getExchangeRateType()) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType());
        } elseif ($this->getExchangeRateValue()) {
            $xml->writeElement('exchrate', $this->getExchangeRateValue());
        } elseif ($this->getBaseCurrency() || $this->getTransactionCurrency()) {
            $xml->writeElement('exchratetype', $this->getExchangeRateType(), true);
        }

        if (count($this->getApplyToTransactions()) > 0) {
            foreach ($this->getApplyToTransactions() as $applyToTransaction) {
                if ($applyToTransaction instanceof ArPaymentItem) {
                    $applyToTransaction->writeXml($xml);
                } elseif (is_array($applyToTransaction)) {
                    $applyToTransaction = new ArPaymentItem($applyToTransaction);

                    $applyToTransaction->writeXml($xml);
                }
            }
        }

        //TODO online payment methods

        $xml->endElement(); //create_arpayment

        $xml->endElement(); //function
    }
}
