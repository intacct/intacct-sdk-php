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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractUser extends AbstractFunction
{

    /** @var string */
    const USER_TYPE_BUSINESS = 'business user';

    /** @var string */
    const USER_TYPE_EMPLOYEE = 'employee user';

    /** @var string */
    const USER_TYPE_PROJECT_MANAGER = 'project manager user';

    /** @var string */
    const USER_TYPE_PAYMENT_APPROVER = 'payment approver';

    /** @var string */
    const USER_TYPE_PLATFORM = 'platform user';

    /** @var string */
    const USER_TYPE_CRM = 'CRM user';

    use CustomFieldsTrait;

    /** @var string */
    protected $userId;

    /** @var string */
    protected $userName;

    /** @var string */
    protected $userType;

    /** @var bool */
    protected $active;

    /** @var bool */
    protected $webServicesOnly;

    /** @var array */
    protected $restrictedEntities;

    /** @var array */
    protected $restrictedDepartments;

    /** @var bool */
    protected $ssoEnabled;

    /** @var string */
    protected $ssoFederatedUserId;

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
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
     * @return boolean
     */
    public function isWebServicesOnly()
    {
        return $this->webServicesOnly;
    }

    /**
     * @param boolean $webServicesOnly
     */
    public function setWebServicesOnly($webServicesOnly)
    {
        $this->webServicesOnly = $webServicesOnly;
    }

    /**
     * @return array
     */
    public function getRestrictedEntities()
    {
        return $this->restrictedEntities;
    }

    /**
     * @param array $restrictedEntities
     */
    public function setRestrictedEntities($restrictedEntities)
    {
        $this->restrictedEntities = $restrictedEntities;
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
     * @return boolean
     */
    public function isSsoEnabled()
    {
        return $this->ssoEnabled;
    }

    /**
     * @param boolean $ssoEnabled
     */
    public function setSsoEnabled($ssoEnabled)
    {
        $this->ssoEnabled = $ssoEnabled;
    }

    /**
     * @return string
     */
    public function getSsoFederatedUserId()
    {
        return $this->ssoFederatedUserId;
    }

    /**
     * @param string $ssoFederatedUserId
     */
    public function setSsoFederatedUserId($ssoFederatedUserId)
    {
        $this->ssoFederatedUserId = $ssoFederatedUserId;
    }
}
