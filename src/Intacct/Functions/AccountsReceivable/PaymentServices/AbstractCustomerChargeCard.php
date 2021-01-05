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

namespace Intacct\Functions\AccountsReceivable\PaymentServices;

use Intacct\Functions\AbstractFunction;
use InvalidArgumentException;

abstract class AbstractCustomerChargeCard extends AbstractFunction
{

    /** @var string */
    const CARD_TYPE_VISA = 'Visa';

    /** @var string */
    const CARD_TYPE_MASTERCARD = 'Mastercard';

    /** @var string */
    const CARD_TYPE_DISCOVER = 'Discover';

    /** @var string */
    const CARD_TYPE_AMEX = 'American Express';

    /** @var string */
    const CARD_TYPE_DINERSCLUB = 'Diners Club';

    /** @var string */
    const CARD_TYPE_OTHER = 'Other Charge Card';

    /** @var int|string */
    protected $recordNo;

    /** @var string */
    protected $customerId;

    /** @var string */
    protected $cardNumber;

    /** @var string */
    protected $cardType;

    /** @var string */
    protected $expirationMonth;

    /** @var string */
    protected $expirationYear;

    /** @var bool */
    protected $active;

    /** @var string */
    protected $description;

    /** @var bool */
    protected $defaultCard;

    /** @var bool */
    protected $billToContactAddressUsedForVerification;

    /** @var string */
    protected $addressLine1;

    /** @var string */
    protected $addressLine2;

    /** @var string */
    protected $city;

    /** @var string */
    protected $stateProvince;

    /** @var string */
    protected $zipPostalCode;

    /** @var string */
    protected $country;

    /**
     * @return int|string
     */
    public function getRecordNo()
    {
        return $this->recordNo;
    }

    /**
     * @param int|string $recordNo
     */
    public function setRecordNo($recordNo)
    {
        $this->recordNo = $recordNo;
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
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @param string $cardType
     */
    public function setCardType($cardType)
    {
        $cardTypes = [
            static::CARD_TYPE_VISA,
            static::CARD_TYPE_MASTERCARD,
            static::CARD_TYPE_DISCOVER,
            static::CARD_TYPE_AMEX,
            static::CARD_TYPE_DINERSCLUB,
            static::CARD_TYPE_OTHER,
        ];
        if (!in_array($cardType, $cardTypes)) {
            throw new InvalidArgumentException('Card Type is not valid');
        }
        $this->cardType = $cardType;
    }

    /**
     * @return string
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     * @param string $expirationMonth
     * @throws InvalidArgumentException
     */
    public function setExpirationMonth($expirationMonth)
    {
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
        if (!in_array($expirationMonth, $months)) {
            throw new InvalidArgumentException('Expiration Month is not a valid month (January, February, etc)');
        }
        $this->expirationMonth = $expirationMonth;
    }

    /**
     * @return string
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     * @param string $expirationYear
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isDefaultCard()
    {
        return $this->defaultCard;
    }

    /**
     * @param bool $defaultCard
     */
    public function setDefaultCard($defaultCard)
    {
        $this->defaultCard = $defaultCard;
    }

    /**
     * @return bool
     */
    public function isBillToContactAddressUsedForVerification()
    {
        return $this->billToContactAddressUsedForVerification;
    }

    /**
     * @param bool $billToContactAddressUsedForVerification
     */
    public function setBillToContactAddressUsedForVerification($billToContactAddressUsedForVerification)
    {
        $this->billToContactAddressUsedForVerification = $billToContactAddressUsedForVerification;
    }

    /**
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param string $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param string $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * @param string $stateProvince
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
    }

    /**
     * @return string
     */
    public function getZipPostalCode()
    {
        return $this->zipPostalCode;
    }

    /**
     * @param string $zipPostalCode
     */
    public function setZipPostalCode($zipPostalCode)
    {
        $this->zipPostalCode = $zipPostalCode;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
