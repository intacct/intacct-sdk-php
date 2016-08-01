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
use Intacct\Functions\AbstractFunction;

abstract class AbstractArPayment extends AbstractFunction
{

    /** @var string */
    const PAYMENT_METHOD_CHECK = 'Printed Check';

    /** @var string */
    const PAYMENT_METHOD_CASH = 'Cash';

    /** @var string */
    const PAYMENT_METHOD_RECORD_TRANSFER = 'EFT';

    /** @var string */
    const PAYMENT_METHOD_CREDIT_CARD = 'Credit Card';

    /** @var string */
    const PAYMENT_METHOD_ONLINE = 'Online';

    /** @var string */
    const PAYMENT_METHOD_ONLINE_CREDIT_CARD = 'Online Charge Card';

    /** @var string */
    const PAYMENT_METHOD_ONLINE_ACH_DEBIT = 'Online ACH Debit';

    /** @var array */
    const PAYMENT_METHODS = [
        'Printed Check',
        'Cash',
        'EFT',
        'Credit Card',
        'Online',
        //'Online Charge Card',
        //'Online ACH Debit',
    ];

    /** @var string */
    protected $paymentMethod;

    /** @var string */
    protected $bankAccountId;

    /** @var string */
    protected $undepositedFundsGlAccountNo;

    /** @var string */
    protected $transactionCurrency;

    /** @var string */
    protected $baseCurrency;

    /** @var string */
    protected $customerId;

    /** @var Date */
    protected $receivedDate;

    /** @var float|string */
    protected $transactionPaymentAmount;

    /** @var float|string */
    protected $basePaymentAmount;

    /** @var Date */
    protected $exchangeRateDate;

    /** @var float */
    protected $exchangeRateValue;

    /** @var string */
    protected $exchangeRateType;

    /** @var string */
    protected $authorizationCode;

    /** @var string */
    protected $overpaymentLocationId;

    /** @var string */
    protected $overpaymentDepartmentId;

    /** @var string */
    protected $referenceNumber;

    /** @var array */
    protected $applyToTransactions;
}
