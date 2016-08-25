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

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

abstract class AbstractVendor extends AbstractFunction
{

    const RESTRICTION_TYPE_UNRESTRICTED = 'Unrestricted';

    const RESTRICTION_TYPE_TOPLEVEL = 'RootOnly';

    const RESTRICTION_TYPE_RESTRICTED = 'Restricted';

    use CustomFieldsTrait;

    /** @var string */
    protected $vendorId;

    /** @var string */
    protected $vendorName;

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
    protected $vendorTypeId;

    /** @var string */
    protected $parentVendorId;

    /** @var string */
    protected $glGroupName;

    /** @var string */
    protected $taxId;

    /** @var string */
    protected $form1099Name;

    /** @var string */
    protected $form1099Type;

    /** @var int|string */
    protected $form1099Box;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $defaultExpenseGlAccountNo;

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $contactTaxGroupName;

    /** @var float|string|int */
    protected $creditLimit;

    /** @var bool */
    protected $onHold;

    /** @var bool */
    protected $doNotPay;

    /** @var string */
    protected $comments;

    /** @var string */
    protected $defaultCurrency;

    /** @var string */
    protected $primaryContactName;

    /** @var string */
    protected $payToContactName;

    /** @var string */
    protected $returnToContactName;

    // TODO contact list

    /** @var string */
    protected $preferredPaymentMethod;

    /** @var bool */
    protected $sendAutomaticPaymentNotification;

    /** @var bool */
    protected $mergePaymentRequests;

    /** @var string */
    protected $vendorBillingType;

    // TODO default bill payment date

    /** @var string */
    protected $paymentPriority;

    /** @var string */
    protected $paymentTerm;

    /** @var bool */
    protected $termDiscountDisplayedOnCheckStub;

    /** @var bool */
    protected $achEnabled;

    /** @var string */
    protected $achBankRoutingNo;

    /** @var string */
    protected $achBankAccountNo;

    /** @var string */
    protected $achBankAccountType;

    /** @var string */
    protected $achBankAccountClass;

    // TODO check delivery and ACH payment services

    /** @var string */
    protected $vendorAccountNo;

    /** @var bool */
    protected $locationAssignedAccountNoDisplayedOnCheckStub;

    // TODO location assigned vendor account no's

    /** @var string */
    protected $restrictionType;

    /** @var array */
    protected $restrictedLocations;

    /** @var array */
    protected $restrictedDepartments;

    /**
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @return string
     */
    public function getVendorName()
    {
        return $this->vendorName;
    }

    /**
     * @param string $vendorName
     */
    public function setVendorName($vendorName)
    {
        $this->vendorName = $vendorName;
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
    public function getVendorTypeId()
    {
        return $this->vendorTypeId;
    }

    /**
     * @param string $vendorTypeId
     */
    public function setVendorTypeId($vendorTypeId)
    {
        $this->vendorTypeId = $vendorTypeId;
    }

    /**
     * @return string
     */
    public function getParentVendorId()
    {
        return $this->parentVendorId;
    }

    /**
     * @param string $parentVendorId
     */
    public function setParentVendorId($parentVendorId)
    {
        $this->parentVendorId = $parentVendorId;
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
     * @return string
     */
    public function getForm1099Name()
    {
        return $this->form1099Name;
    }

    /**
     * @param string $form1099Name
     */
    public function setForm1099Name($form1099Name)
    {
        $this->form1099Name = $form1099Name;
    }

    /**
     * @return string
     */
    public function getForm1099Type()
    {
        return $this->form1099Type;
    }

    /**
     * @param string $form1099Type
     */
    public function setForm1099Type($form1099Type)
    {
        $this->form1099Type = $form1099Type;
    }

    /**
     * @return int|string
     */
    public function getForm1099Box()
    {
        return $this->form1099Box;
    }

    /**
     * @param int|string $form1099Box
     */
    public function setForm1099Box($form1099Box)
    {
        $this->form1099Box = $form1099Box;
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
    public function getDefaultExpenseGlAccountNo()
    {
        return $this->defaultExpenseGlAccountNo;
    }

    /**
     * @param string $defaultExpenseGlAccountNo
     */
    public function setDefaultExpenseGlAccountNo($defaultExpenseGlAccountNo)
    {
        $this->defaultExpenseGlAccountNo = $defaultExpenseGlAccountNo;
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
     * @return boolean
     */
    public function isDoNotPay()
    {
        return $this->doNotPay;
    }

    /**
     * @param boolean $doNotPay
     */
    public function setDoNotPay($doNotPay)
    {
        $this->doNotPay = $doNotPay;
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
    public function getPayToContactName()
    {
        return $this->payToContactName;
    }

    /**
     * @param string $payToContactName
     */
    public function setPayToContactName($payToContactName)
    {
        $this->payToContactName = $payToContactName;
    }

    /**
     * @return string
     */
    public function getReturnToContactName()
    {
        return $this->returnToContactName;
    }

    /**
     * @param string $returnToContactName
     */
    public function setReturnToContactName($returnToContactName)
    {
        $this->returnToContactName = $returnToContactName;
    }

    /**
     * @return string
     */
    public function getPreferredPaymentMethod()
    {
        return $this->preferredPaymentMethod;
    }

    /**
     * @param string $preferredPaymentMethod
     */
    public function setPreferredPaymentMethod($preferredPaymentMethod)
    {
        $this->preferredPaymentMethod = $preferredPaymentMethod;
    }

    /**
     * @return boolean
     */
    public function isSendAutomaticPaymentNotification()
    {
        return $this->sendAutomaticPaymentNotification;
    }

    /**
     * @param boolean $sendAutomaticPaymentNotification
     */
    public function setSendAutomaticPaymentNotification($sendAutomaticPaymentNotification)
    {
        $this->sendAutomaticPaymentNotification = $sendAutomaticPaymentNotification;
    }

    /**
     * @return boolean
     */
    public function isMergePaymentRequests()
    {
        return $this->mergePaymentRequests;
    }

    /**
     * @param boolean $mergePaymentRequests
     */
    public function setMergePaymentRequests($mergePaymentRequests)
    {
        $this->mergePaymentRequests = $mergePaymentRequests;
    }

    /**
     * @return string
     */
    public function getVendorBillingType()
    {
        return $this->vendorBillingType;
    }

    /**
     * @param string $vendorBillingType
     */
    public function setVendorBillingType($vendorBillingType)
    {
        $this->vendorBillingType = $vendorBillingType;
    }

    /**
     * @return string
     */
    public function getPaymentPriority()
    {
        return $this->paymentPriority;
    }

    /**
     * @param string $paymentPriority
     */
    public function setPaymentPriority($paymentPriority)
    {
        $this->paymentPriority = $paymentPriority;
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
     * @return boolean
     */
    public function isTermDiscountDisplayedOnCheckStub()
    {
        return $this->termDiscountDisplayedOnCheckStub;
    }

    /**
     * @param boolean $termDiscountDisplayedOnCheckStub
     */
    public function setTermDiscountDisplayedOnCheckStub($termDiscountDisplayedOnCheckStub)
    {
        $this->termDiscountDisplayedOnCheckStub = $termDiscountDisplayedOnCheckStub;
    }

    /**
     * @return boolean
     */
    public function isAchEnabled()
    {
        return $this->achEnabled;
    }

    /**
     * @param boolean $achEnabled
     */
    public function setAchEnabled($achEnabled)
    {
        $this->achEnabled = $achEnabled;
    }

    /**
     * @return string
     */
    public function getAchBankRoutingNo()
    {
        return $this->achBankRoutingNo;
    }

    /**
     * @param string $achBankRoutingNo
     */
    public function setAchBankRoutingNo($achBankRoutingNo)
    {
        $this->achBankRoutingNo = $achBankRoutingNo;
    }

    /**
     * @return string
     */
    public function getAchBankAccountNo()
    {
        return $this->achBankAccountNo;
    }

    /**
     * @param string $achBankAccountNo
     */
    public function setAchBankAccountNo($achBankAccountNo)
    {
        $this->achBankAccountNo = $achBankAccountNo;
    }

    /**
     * @return string
     */
    public function getAchBankAccountType()
    {
        return $this->achBankAccountType;
    }

    /**
     * @param string $achBankAccountType
     */
    public function setAchBankAccountType($achBankAccountType)
    {
        $this->achBankAccountType = $achBankAccountType;
    }

    /**
     * @return string
     */
    public function getAchBankAccountClass()
    {
        return $this->achBankAccountClass;
    }

    /**
     * @param string $achBankAccountClass
     */
    public function setAchBankAccountClass($achBankAccountClass)
    {
        $this->achBankAccountClass = $achBankAccountClass;
    }

    /**
     * @return string
     */
    public function getVendorAccountNo()
    {
        return $this->vendorAccountNo;
    }

    /**
     * @param string $vendorAccountNo
     */
    public function setVendorAccountNo($vendorAccountNo)
    {
        $this->vendorAccountNo = $vendorAccountNo;
    }

    /**
     * @return boolean
     */
    public function isLocationAssignedAccountNoDisplayedOnCheckStub()
    {
        return $this->locationAssignedAccountNoDisplayedOnCheckStub;
    }

    /**
     * @param boolean $locationAssignedAccountNoDisplayedOnCheckStub
     */
    public function setLocationAssignedAccountNoDisplayedOnCheckStub($locationAssignedAccountNoDisplayedOnCheckStub)
    {
        $this->locationAssignedAccountNoDisplayedOnCheckStub = $locationAssignedAccountNoDisplayedOnCheckStub;
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
