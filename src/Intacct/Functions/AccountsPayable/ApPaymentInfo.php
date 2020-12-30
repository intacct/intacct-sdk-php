<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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
    public string $paymentMethod;

    /** @var string */
    public string $financialEntityId;

    /** @var string */
    public string $vendorId;

    /** @var string */
    public string $mergeOption;

    /** @var bool */
    public bool $groupPayments;

    /** @var \DateTime */
    public DateTime $paymentDate;

    /** @var string */
    public string $baseCurrency;

    /** @var string */
    public string $transactionCurrency;

    /** @var int */
    public int $transactionAmountPaid;

    /** @var \DateTime */
    public \DateTime $exchangeRateDate;

    /** @var string */
    public string $exchangeRateType;

    /** @var string */
    public string $documentNo;

    /** @var string */
    public string $memo;

    /** @var string */
    public string $notificationContactName;

    /** @var string */
    public string $action;

    /** @var array */
    public array $apPaymentDetails;
}