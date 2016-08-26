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

namespace Intacct\Functions\AccountsReceivable;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractCustomer extends AbstractFunction
{

    /** @var string */
    const RESTRICTION_TYPE_UNRESTRICTED = 'Unrestricted';

    /** @var string */
    const RESTRICTION_TYPE_TOPLEVEL = 'RootOnly';

    /** @var string */
    const RESTRICTION_TYPE_RESTRICTED = 'Restricted';

    use CustomFieldsTrait;

    /** @var string */
    protected $customerId;

    /** @var string */
    protected $customerName;

    /** @var bool */
    protected $oneTime;

    /** @var bool */
    protected $active;

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

    /** @var bool */
    protected $excludedFromContactList;

    /** @var string */
    protected $customerTypeId;

    /** @var string */
    protected $salesRepEmployeeId;

    /** @var string */
    protected $parentCustomerId;

    /** @var string */
    protected $glGroupName;

    /** @var string */
    protected $territoryId;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $paymentTerm;

    /** @var string */
    protected $offsetArGlAccountNo;

    /** @var string */
    protected $defaultRevenueGlAccountNo;

    /** @var string */
    protected $shippingMethod;

    /** @var string */
    protected $resaleNumber;

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $contactTaxGroupName;

    /** @var string */
    protected $taxId;

    /** @var float|string|int */
    protected $creditLimit;

    /** @var bool */
    protected $onHold;

    /** @var string */
    protected $deliveryMethod;

    /** @var string */
    protected $defaultInvoiceMessage;

    /** @var string */
    protected $comments;

    /** @var string */
    protected $defaultCurrency;

    /** @var string */
    protected $printOptionArInvoiceTemplateName;

    /** @var string */
    protected $printOptionOeQuoteTemplateName;

    /** @var string */
    protected $printOptionOeOrderTemplateName;

    /** @var string */
    protected $printOptionOeListTemplateName;

    /** @var string */
    protected $printOptionOeInvoiceTemplateName;

    /** @var string */
    protected $printOptionOeAdjustmentTemplateName;

    /** @var string */
    protected $printOptionOeOtherTemplateName;

    // TODO: Email template options

    /** @var string */
    protected $primaryContactName;

    /** @var string */
    protected $billToContactName;

    /** @var string */
    protected $shipToContactName;

    // TODO contact list

    /** @var string */
    protected $restrictionType;

    /** @var array */
    protected $restrictedLocations;

    /** @var array */
    protected $restrictedDepartments;

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
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    /**
     * @return boolean
     */
    public function isOneTime()
    {
        return $this->oneTime;
    }

    /**
     * @param boolean $oneTime
     */
    public function setOneTime($oneTime)
    {
        $this->oneTime = $oneTime;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getPrintAs()
    {
        return $this->printAs;
    }

    /**
     * @param string $printAs
     */
    public function setPrintAs($printAs)
    {
        $this->printAs = $printAs;
    }

    /**
     * @return string
     */
    public function getPrimaryPhoneNo()
    {
        return $this->primaryPhoneNo;
    }

    /**
     * @param string $primaryPhoneNo
     */
    public function setPrimaryPhoneNo($primaryPhoneNo)
    {
        $this->primaryPhoneNo = $primaryPhoneNo;
    }

    /**
     * @return string
     */
    public function getSecondaryPhoneNo()
    {
        return $this->secondaryPhoneNo;
    }

    /**
     * @param string $secondaryPhoneNo
     */
    public function setSecondaryPhoneNo($secondaryPhoneNo)
    {
        $this->secondaryPhoneNo = $secondaryPhoneNo;
    }

    /**
     * @return string
     */
    public function getCellularPhoneNo()
    {
        return $this->cellularPhoneNo;
    }

    /**
     * @param string $cellularPhoneNo
     */
    public function setCellularPhoneNo($cellularPhoneNo)
    {
        $this->cellularPhoneNo = $cellularPhoneNo;
    }

    /**
     * @return string
     */
    public function getPagerNo()
    {
        return $this->pagerNo;
    }

    /**
     * @param string $pagerNo
     */
    public function setPagerNo($pagerNo)
    {
        $this->pagerNo = $pagerNo;
    }

    /**
     * @return string
     */
    public function getFaxNo()
    {
        return $this->faxNo;
    }

    /**
     * @param string $faxNo
     */
    public function setFaxNo($faxNo)
    {
        $this->faxNo = $faxNo;
    }

    /**
     * @return string
     */
    public function getPrimaryEmailAddress()
    {
        return $this->primaryEmailAddress;
    }

    /**
     * @param string $primaryEmailAddress
     */
    public function setPrimaryEmailAddress($primaryEmailAddress)
    {
        $this->primaryEmailAddress = $primaryEmailAddress;
    }

    /**
     * @return string
     */
    public function getSecondaryEmailAddress()
    {
        return $this->secondaryEmailAddress;
    }

    /**
     * @param string $secondaryEmailAddress
     */
    public function setSecondaryEmailAddress($secondaryEmailAddress)
    {
        $this->secondaryEmailAddress = $secondaryEmailAddress;
    }

    /**
     * @return string
     */
    public function getPrimaryUrl()
    {
        return $this->primaryUrl;
    }

    /**
     * @param string $primaryUrl
     */
    public function setPrimaryUrl($primaryUrl)
    {
        $this->primaryUrl = $primaryUrl;
    }

    /**
     * @return string
     */
    public function getSecondaryUrl()
    {
        return $this->secondaryUrl;
    }

    /**
     * @param string $secondaryUrl
     */
    public function setSecondaryUrl($secondaryUrl)
    {
        $this->secondaryUrl = $secondaryUrl;
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

    /**
     * @return boolean
     */
    public function isExcludedFromContactList()
    {
        return $this->excludedFromContactList;
    }

    /**
     * @param boolean $excludedFromContactList
     */
    public function setExcludedFromContactList($excludedFromContactList)
    {
        $this->excludedFromContactList = $excludedFromContactList;
    }

    /**
     * @return string
     */
    public function getCustomerTypeId()
    {
        return $this->customerTypeId;
    }

    /**
     * @param string $customerTypeId
     */
    public function setCustomerTypeId($customerTypeId)
    {
        $this->customerTypeId = $customerTypeId;
    }

    /**
     * @return string
     */
    public function getSalesRepEmployeeId()
    {
        return $this->salesRepEmployeeId;
    }

    /**
     * @param string $salesRepEmployeeId
     */
    public function setSalesRepEmployeeId($salesRepEmployeeId)
    {
        $this->salesRepEmployeeId = $salesRepEmployeeId;
    }

    /**
     * @return string
     */
    public function getParentCustomerId()
    {
        return $this->parentCustomerId;
    }

    /**
     * @param string $parentCustomerId
     */
    public function setParentCustomerId($parentCustomerId)
    {
        $this->parentCustomerId = $parentCustomerId;
    }

    /**
     * @return string
     */
    public function getGlGroupName()
    {
        return $this->glGroupName;
    }

    /**
     * @param string $glGroupName
     */
    public function setGlGroupName($glGroupName)
    {
        $this->glGroupName = $glGroupName;
    }

    /**
     * @return string
     */
    public function getTerritoryId()
    {
        return $this->territoryId;
    }

    /**
     * @param string $territoryId
     */
    public function setTerritoryId($territoryId)
    {
        $this->territoryId = $territoryId;
    }

    /**
     * @return string
     */
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
    }

    /**
     * @return string
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    /**
     * @param string $paymentTerm
     */
    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;
    }

    /**
     * @return string
     */
    public function getOffsetArGlAccountNo()
    {
        return $this->offsetArGlAccountNo;
    }

    /**
     * @param string $offsetArGlAccountNo
     */
    public function setOffsetArGlAccountNo($offsetArGlAccountNo)
    {
        $this->offsetArGlAccountNo = $offsetArGlAccountNo;
    }

    /**
     * @return string
     */
    public function getDefaultRevenueGlAccountNo()
    {
        return $this->defaultRevenueGlAccountNo;
    }

    /**
     * @param string $defaultRevenueGlAccountNo
     */
    public function setDefaultRevenueGlAccountNo($defaultRevenueGlAccountNo)
    {
        $this->defaultRevenueGlAccountNo = $defaultRevenueGlAccountNo;
    }

    /**
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param string $shippingMethod
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return string
     */
    public function getResaleNumber()
    {
        return $this->resaleNumber;
    }

    /**
     * @param string $resaleNumber
     */
    public function setResaleNumber($resaleNumber)
    {
        $this->resaleNumber = $resaleNumber;
    }

    /**
     * @return boolean
     */
    public function isTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param boolean $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    }

    /**
     * @return string
     */
    public function getContactTaxGroupName()
    {
        return $this->contactTaxGroupName;
    }

    /**
     * @param string $contactTaxGroupName
     */
    public function setContactTaxGroupName($contactTaxGroupName)
    {
        $this->contactTaxGroupName = $contactTaxGroupName;
    }

    /**
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * @param string $taxId
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;
    }

    /**
     * @return boolean
     */
    public function isOnHold()
    {
        return $this->onHold;
    }

    /**
     * @param boolean $onHold
     */
    public function setOnHold($onHold)
    {
        $this->onHold = $onHold;
    }

    /**
     * @return float|int|string
     */
    public function getCreditLimit()
    {
        return $this->creditLimit;
    }

    /**
     * @param float|int|string $creditLimit
     */
    public function setCreditLimit($creditLimit)
    {
        $this->creditLimit = $creditLimit;
    }

    /**
     * @return string
     */
    public function getDeliveryMethod()
    {
        return $this->deliveryMethod;
    }

    /**
     * @param string $deliveryMethod
     */
    public function setDeliveryMethod($deliveryMethod)
    {
        $this->deliveryMethod = $deliveryMethod;
    }

    /**
     * @return string
     */
    public function getDefaultInvoiceMessage()
    {
        return $this->defaultInvoiceMessage;
    }

    /**
     * @param string $defaultInvoiceMessage
     */
    public function setDefaultInvoiceMessage($defaultInvoiceMessage)
    {
        $this->defaultInvoiceMessage = $defaultInvoiceMessage;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    /**
     * @param string $defaultCurrency
     */
    public function setDefaultCurrency($defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * @return string
     */
    public function getPrintOptionArInvoiceTemplateName()
    {
        return $this->printOptionArInvoiceTemplateName;
    }

    /**
     * @param string $printOptionArInvoiceTemplateName
     */
    public function setPrintOptionArInvoiceTemplateName(
        $printOptionArInvoiceTemplateName
    ) {
        $this->printOptionArInvoiceTemplateName
            = $printOptionArInvoiceTemplateName;
    }

    /**
     * @return string
     */
    public function getPrintOptionOeQuoteTemplateName()
    {
        return $this->printOptionOeQuoteTemplateName;
    }

    /**
     * @param string $printOptionOeQuoteTemplateName
     */
    public function setPrintOptionOeQuoteTemplateName(
        $printOptionOeQuoteTemplateName
    ) {
        $this->printOptionOeQuoteTemplateName = $printOptionOeQuoteTemplateName;
    }

    /**
     * @return string
     */
    public function getPrintOptionOeOrderTemplateName()
    {
        return $this->printOptionOeOrderTemplateName;
    }

    /**
     * @param string $printOptionOeOrderTemplateName
     */
    public function setPrintOptionOeOrderTemplateName(
        $printOptionOeOrderTemplateName
    ) {
        $this->printOptionOeOrderTemplateName = $printOptionOeOrderTemplateName;
    }

    /**
     * @return string
     */
    public function getPrintOptionOeListTemplateName()
    {
        return $this->printOptionOeListTemplateName;
    }

    /**
     * @param string $printOptionOeListTemplateName
     */
    public function setPrintOptionOeListTemplateName(
        $printOptionOeListTemplateName
    ) {
        $this->printOptionOeListTemplateName = $printOptionOeListTemplateName;
    }

    /**
     * @return string
     */
    public function getPrintOptionOeInvoiceTemplateName()
    {
        return $this->printOptionOeInvoiceTemplateName;
    }

    /**
     * @param string $printOptionOeInvoiceTemplateName
     */
    public function setPrintOptionOeInvoiceTemplateName(
        $printOptionOeInvoiceTemplateName
    ) {
        $this->printOptionOeInvoiceTemplateName
            = $printOptionOeInvoiceTemplateName;
    }

    /**
     * @return string
     */
    public function getPrintOptionOeAdjustmentTemplateName()
    {
        return $this->printOptionOeAdjustmentTemplateName;
    }

    /**
     * @param string $printOptionOeAdjustmentTemplateName
     */
    public function setPrintOptionOeAdjustmentTemplateName(
        $printOptionOeAdjustmentTemplateName
    ) {
        $this->printOptionOeAdjustmentTemplateName = $printOptionOeAdjustmentTemplateName;
    }

    /**
     * @return string
     */
    public function getPrintOptionOeOtherTemplateName()
    {
        return $this->printOptionOeOtherTemplateName;
    }

    /**
     * @param string $printOptionOeOtherTemplateName
     */
    public function setPrintOptionOeOtherTemplateName(
        $printOptionOeOtherTemplateName
    ) {
        $this->printOptionOeOtherTemplateName = $printOptionOeOtherTemplateName;
    }

    /**
     * @return string
     */
    public function getPrimaryContactName()
    {
        return $this->primaryContactName;
    }

    /**
     * @param string $primaryContactName
     */
    public function setPrimaryContactName($primaryContactName)
    {
        $this->primaryContactName = $primaryContactName;
    }

    /**
     * @return string
     */
    public function getBillToContactName()
    {
        return $this->billToContactName;
    }

    /**
     * @param string $billToContactName
     */
    public function setBillToContactName($billToContactName)
    {
        $this->billToContactName = $billToContactName;
    }

    /**
     * @return string
     */
    public function getShipToContactName()
    {
        return $this->shipToContactName;
    }

    /**
     * @param string $shipToContactName
     */
    public function setShipToContactName($shipToContactName)
    {
        $this->shipToContactName = $shipToContactName;
    }

    /**
     * @return string
     */
    public function getRestrictionType()
    {
        return $this->restrictionType;
    }

    /**
     * @param string $restrictionType
     */
    public function setRestrictionType($restrictionType)
    {
        $restrictionTypes = [
            static::RESTRICTION_TYPE_UNRESTRICTED,
            static::RESTRICTION_TYPE_RESTRICTED,
            static::RESTRICTION_TYPE_TOPLEVEL,
        ];
        if (!in_array($restrictionType, $restrictionTypes)) {
            throw new InvalidArgumentException('Restriction Type is not valid');
        }
        $this->restrictionType = $restrictionType;
    }

    /**
     * @return array
     */
    public function getRestrictedLocations()
    {
        return $this->restrictedLocations;
    }

    /**
     * @param array $restrictedLocations
     */
    public function setRestrictedLocations($restrictedLocations)
    {
        $this->restrictedLocations = $restrictedLocations;
    }

    /**
     * @return array
     */
    public function getRestrictedDepartments()
    {
        return $this->restrictedDepartments;
    }

    /**
     * @param array $restrictedDepartments
     */
    public function setRestrictedDepartments($restrictedDepartments)
    {
        $this->restrictedDepartments = $restrictedDepartments;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXmlMailAddress(XMLWriter &$xml)
    {
        if (
            $this->getAddressLine1()
            || $this->getAddressLine2()
            || $this->getCity()
            || $this->getStateProvince()
            || $this->getZipPostalCode()
            || $this->getCountry()
        ) {
            $xml->startElement('MAILADDRESS');

            $xml->writeElement('ADDRESS1', $this->getAddressLine1());
            $xml->writeElement('ADDRESS2', $this->getAddressLine2());
            $xml->writeElement('CITY', $this->getCity());
            $xml->writeElement('STATE', $this->getStateProvince());
            $xml->writeElement('ZIP', $this->getZipPostalCode());
            $xml->writeElement('COUNTRY', $this->getCountry());

            $xml->endElement(); //MAILADDRESS
        }
    }
}
