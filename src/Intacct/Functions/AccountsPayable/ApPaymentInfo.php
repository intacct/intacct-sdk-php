<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

use DateTime;

class ApPaymentInfo
{
    /** @var string */
    const PAYMENT_METHOD_CHECK = 'Printed Check';

    /** @var string */
    const PAYMENT_METHOD_CASH = 'Cash';

    /** @var string */
    const PAYMENT_METHOD_RECORD_TRANSFER = 'EFT';

    /** @var string */
    const PAYMENT_METHOD_CHARGE_CARD = 'Charge Card';

    /** @var string */
    const PAYMENT_METHOD_ACH = 'ACH';

    /** @var string */
    public $paymentMethod;

    /** @var string */
    public $financialEntityId;

    /** @var string */
    public $vendorId;

    /** @var string */
    public $mergeOption;

    /** @var bool */
    public $groupPayments;

    /** @var \DateTime */
    public $paymentDate;

    /** @var string */
    public $baseCurrency;

    /** @var string */
    public $transactionCurrency;

    /** @var int */
    public $transactionAmountPaid;

    /** @var \DateTime */
    public $exchangeRateDate;

    /** @var string */
    public $exchangeRateType;

    /** @var string */
    public $documentNo;

    /** @var string */
    public $memo;

    /** @var string */
    public $notificationContactName;

    /** @var string */
    public $action;

    /** @var array */
    public $apPaymentDetails;
}