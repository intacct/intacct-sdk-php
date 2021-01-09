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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

abstract class AbstractContact extends AbstractFunction
{

    /** @var string */
    protected $contactName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $middleName;

    /** @var string */
    protected $prefix;

    /** @var string */
    protected $companyName;

    /** @var string */
    protected $printAs;

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $taxId;

    /** @var string */
    protected $contactTaxGroupName;

    /** @var bool */
    protected $active;

    /** @var string */
    protected $primaryPhoneNo;

    /** @var string */
    protected $secondaryPhoneNo;

    /** @var string */
    protected $cellularPhoneNo;

    /** @var string */
    protected $pagerNo;

    /** @var string */
    protected $faxNo;

    /** @var string */
    protected $primaryEmailAddress;

    /** @var string */
    protected $secondaryEmailAddress;

    /** @var string */
    protected $primaryUrl;

    /** @var string */
    protected $secondaryUrl;

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

    /** @var string */
    protected $isoCountryCode;

    /**
     * Get contact name
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contact name
     *
     * @param string $contactName
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set last name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set first name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get middle name
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set middle name
     *
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Get company name
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set company name
     *
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * Get print as
     *
     * @return string
     */
    public function getPrintAs()
    {
        return $this->printAs;
    }

    /**
     * Set print as
     *
     * @param string $printAs
     */
    public function setPrintAs($printAs)
    {
        $this->printAs = $printAs;
    }

    /**
     * Get taxable
     *
     * @return bool
     */
    public function isTaxable()
    {
        return $this->taxable;
    }

    /**
     * Set taxable
     *
     * @param bool $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    }

    /**
     * Get tax ID
     *
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * Set tax ID
     *
     * @param string $taxId
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;
    }

    /**
     * Get contact tax group name
     *
     * @return string
     */
    public function getContactTaxGroupName()
    {
        return $this->contactTaxGroupName;
    }

    /**
     * Set contact tax group name
     *
     * @param string $contactTaxGroupName
     */
    public function setContactTaxGroupName($contactTaxGroupName)
    {
        $this->contactTaxGroupName = $contactTaxGroupName;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get primary phone number
     *
     * @return string
     */
    public function getPrimaryPhoneNo()
    {
        return $this->primaryPhoneNo;
    }

    /**
     * Set primary phone number
     *
     * @param string $primaryPhoneNo
     */
    public function setPrimaryPhoneNo($primaryPhoneNo)
    {
        $this->primaryPhoneNo = $primaryPhoneNo;
    }

    /**
     * Get secondary phone number
     *
     * @return string
     */
    public function getSecondaryPhoneNo()
    {
        return $this->secondaryPhoneNo;
    }

    /**
     * Set secondary phone number
     *
     * @param string $secondaryPhoneNo
     */
    public function setSecondaryPhoneNo($secondaryPhoneNo)
    {
        $this->secondaryPhoneNo = $secondaryPhoneNo;
    }

    /**
     * Get cellular phone number
     *
     * @return string
     */
    public function getCellularPhoneNo()
    {
        return $this->cellularPhoneNo;
    }

    /**
     * Set cellular phone number
     *
     * @param string $cellularPhoneNo
     */
    public function setCellularPhoneNo($cellularPhoneNo)
    {
        $this->cellularPhoneNo = $cellularPhoneNo;
    }

    /**
     * Get pager number
     *
     * @return string
     */
    public function getPagerNo()
    {
        return $this->pagerNo;
    }

    /**
     * Set pager number
     *
     * @param string $pagerNo
     */
    public function setPagerNo($pagerNo)
    {
        $this->pagerNo = $pagerNo;
    }

    /**
     * Get fax number
     *
     * @return string
     */
    public function getFaxNo()
    {
        return $this->faxNo;
    }

    /**
     * Set fax number
     *
     * @param string $faxNo
     */
    public function setFaxNo($faxNo)
    {
        $this->faxNo = $faxNo;
    }

    /**
     * Get primary email address
     *
     * @return string
     */
    public function getPrimaryEmailAddress()
    {
        return $this->primaryEmailAddress;
    }

    /**
     * Set primary email address
     *
     * @param string $primaryEmailAddress
     */
    public function setPrimaryEmailAddress($primaryEmailAddress)
    {
        if (filter_var($primaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Primary Email Address is not a valid email');
        }
        $this->primaryEmailAddress = $primaryEmailAddress;
    }

    /**
     * Get secondary email address
     *
     * @return string
     */
    public function getSecondaryEmailAddress()
    {
        return $this->secondaryEmailAddress;
    }

    /**
     * Set secondary email address
     *
     * @param string $secondaryEmailAddress
     */
    public function setSecondaryEmailAddress($secondaryEmailAddress)
    {
        if (filter_var($secondaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Secondary Email Address is not a valid email');
        }
        $this->secondaryEmailAddress = $secondaryEmailAddress;
    }

    /**
     * Get primary URL
     *
     * @return string
     */
    public function getPrimaryUrl()
    {
        return $this->primaryUrl;
    }

    /**
     * Set primary URL
     *
     * @param string $primaryUrl
     */
    public function setPrimaryUrl($primaryUrl)
    {
        $this->primaryUrl = $primaryUrl;
    }

    /**
     * Get secondary URL
     *
     * @return string
     */
    public function getSecondaryUrl()
    {
        return $this->secondaryUrl;
    }

    /**
     * Set secondary URL
     *
     * @param string $secondaryUrl
     */
    public function setSecondaryUrl($secondaryUrl)
    {
        $this->secondaryUrl = $secondaryUrl;
    }

    /**
     * Get address line 1
     *
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * Set address line 1
     *
     * @param string $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * Get address line 2
     *
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * Set address line 2
     *
     * @param string $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get state/province
     *
     * @return string
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * Set state/province
     *
     * @param string $stateProvince
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
    }

    /**
     * Get zip/postal code
     *
     * @return string
     */
    public function getZipPostalCode()
    {
        return $this->zipPostalCode;
    }

    /**
     * Set zip/postal code
     *
     * @param string $zipPostalCode
     */
    public function setZipPostalCode($zipPostalCode)
    {
        $this->zipPostalCode = $zipPostalCode;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getIsoCountryCode()
    {
        return $this->isoCountryCode;
    }

    /**
     * @param string $isoCountryCode
     */
    public function setIsoCountryCode($isoCountryCode)
    {
        $this->isoCountryCode = $isoCountryCode;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXmlMailAddress(XMLWriter &$xml)
    {
        if ($this->getAddressLine1()
            || $this->getAddressLine2()
            || $this->getCity()
            || $this->getStateProvince()
            || $this->getZipPostalCode()
            || $this->getCountry()
            || $this->getIsoCountryCode()) {
            $xml->startElement('MAILADDRESS');

            $xml->writeElement('ADDRESS1', $this->getAddressLine1());
            $xml->writeElement('ADDRESS2', $this->getAddressLine2());
            $xml->writeElement('CITY', $this->getCity());
            $xml->writeElement('STATE', $this->getStateProvince());
            $xml->writeElement('ZIP', $this->getZipPostalCode());
            $xml->writeElement('COUNTRY', $this->getCountry());
            $xml->writeElement('COUNTRYCODE', $this->getIsoCountryCode());

            $xml->endElement(); //MAILADDRESS
        }
    }
}
