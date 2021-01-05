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

namespace Intacct\Functions\EmployeeExpense;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractEmployee extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $employeeId;

    /** @var string */
    protected $contactName;

    /** @var \DateTime */
    protected $startDate;

    /** @var string */
    protected $title;

    /** @var string */
    protected $ssn;

    /** @var string */
    protected $employeeType;

    /** @var bool */
    protected $active;

    /** @var bool */
    protected $placeholderResource;

    /** @var \DateTime */
    protected $birthDate;

    /** @var \DateTime */
    protected $endDate;

    /** @var string */
    protected $terminationType;

    /** @var string */
    protected $managerEmployeeId;

    /** @var string */
    protected $gender;

    /** @var string */
    protected $departmentId;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $classId;

    /** @var string */
    protected $defaultCurrency;

    /** @var string */
    protected $earningTypeName;

    /** @var bool */
    protected $postActualCost;

    /** @var string */
    protected $form1099Name;

    /** @var string */
    protected $form1099Type;

    /** @var int|string */
    protected $form1099Box;

    /** @var string */
    protected $attachmentFolderName;

    /** @var string */
    protected $preferredPaymentMethod;

    /** @var bool */
    protected $sendAutomaticPaymentNotification;

    /** @var bool */
    protected $mergePaymentRequests;

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

    /**
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param string $contactName
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * @param string $ssn
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
    }

    /**
     * @return string
     */
    public function getEmployeeType()
    {
        return $this->employeeType;
    }

    /**
     * @param string $employeeType
     */
    public function setEmployeeType($employeeType)
    {
        $this->employeeType = $employeeType;
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
     * @return bool
     */
    public function isPlaceholderResource()
    {
        return $this->placeholderResource;
    }

    /**
     * @param bool $placeholderResource
     */
    public function setPlaceholderResource($placeholderResource)
    {
        $this->placeholderResource = $placeholderResource;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getTerminationType()
    {
        return $this->terminationType;
    }

    /**
     * @param string $terminationType
     */
    public function setTerminationType($terminationType)
    {
        $this->terminationType = $terminationType;
    }

    /**
     * @return string
     */
    public function getManagerEmployeeId()
    {
        return $this->managerEmployeeId;
    }

    /**
     * @param string $managerEmployeeId
     */
    public function setManagerEmployeeId($managerEmployeeId)
    {
        $this->managerEmployeeId = $managerEmployeeId;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * @param string $departmentId
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param string $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return string
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * @param string $classId
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;
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
    public function getEarningTypeName()
    {
        return $this->earningTypeName;
    }

    /**
     * @param string $earningTypeName
     */
    public function setEarningTypeName($earningTypeName)
    {
        $this->earningTypeName = $earningTypeName;
    }

    /**
     * @return bool
     */
    public function isPostActualCost()
    {
        return $this->postActualCost;
    }

    /**
     * @param bool $postActualCost
     */
    public function setPostActualCost($postActualCost)
    {
        $this->postActualCost = $postActualCost;
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
    public function getAttachmentFolderName()
    {
        return $this->attachmentFolderName;
    }

    /**
     * @param string $attachmentFolderName
     */
    public function setAttachmentFolderName($attachmentFolderName)
    {
        $this->attachmentFolderName = $attachmentFolderName;
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
     * @return bool
     */
    public function isSendAutomaticPaymentNotification()
    {
        return $this->sendAutomaticPaymentNotification;
    }

    /**
     * @param bool $sendAutomaticPaymentNotification
     */
    public function setSendAutomaticPaymentNotification(
        $sendAutomaticPaymentNotification
    ) {
        $this->sendAutomaticPaymentNotification
            = $sendAutomaticPaymentNotification;
    }

    /**
     * @return bool
     */
    public function isMergePaymentRequests()
    {
        return $this->mergePaymentRequests;
    }

    /**
     * @param bool $mergePaymentRequests
     */
    public function setMergePaymentRequests($mergePaymentRequests)
    {
        $this->mergePaymentRequests = $mergePaymentRequests;
    }

    /**
     * @return bool
     */
    public function isAchEnabled()
    {
        return $this->achEnabled;
    }

    /**
     * @param bool $achEnabled
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
}
