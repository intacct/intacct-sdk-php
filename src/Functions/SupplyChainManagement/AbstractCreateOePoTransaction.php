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

abstract class AbstractCreateOePoTransaction extends AbstractCreateTransaction
{

    /** @var Date */
    protected $glPostingDate;

    /** @var string */
    protected $paymentTerm;

    /** @var Date */
    protected $dueDate;

    /** @var string */
    protected $shippingMethod;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $transactionCurrency;

    /** @var Date */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var array */
    protected $subtotals;

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
            'gl_posting_date' => null,
            'payment_term' => null,
            'due_date' => null,
            'shipping_method' => null,
            'attachments_id' => null,
            'transaction_currency' => null,
            'exchange_rate_date' => null,
            'exchange_rate_type' => null,
            'exchange_rate' => null,
            'subtotals' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->glPostingDate = $config['gl_posting_date'];
        $this->paymentTerm = $config['payment_term'];
        $this->dueDate = $config['due_date'];
        $this->shippingMethod = $config['shipping_method'];
        $this->attachmentsId = $config['attachments_id'];
        $this->transactionCurrency = $config['transaction_currency'];
        $this->exchangeRateDate = $config['exchange_rate_date'];
        $this->exchangeRateType = $config['exchange_rate_type'];
        $this->exchangeRateValue = $config['exchange_rate'];
        $this->subtotals = $config['subtotals'];
    }

    /**
     * @param XMLWriter $xml
     */
    protected function getSubtotalEntries(XMLWriter &$xml)
    {
        if (count($this->subtotals) > 0) {
            $xml->startElement('subtotals');
            foreach ($this->subtotals as $subtotal) {
                if ($subtotal instanceof CreateTransactionSubtotalEntry) {
                    $subtotal->writeXml($xml);
                } elseif (is_array($subtotal)) {
                    $subtotal = new CreateTransactionSubtotalEntry($subtotal);

                    $subtotal->writeXml($xml);
                }
            }
            $xml->endElement(); //subtotals
        }
    }
}
