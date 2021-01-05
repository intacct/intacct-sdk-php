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

    /** @var string[] */
    protected $restrictedEntities = [];

    /** @var string[] */
    protected $restrictedDepartments = [];

    /** @var bool */
    protected $ssoEnabled;

    /** @var string */
    protected $ssoFederatedUserId;

    /**
     * Get user ID
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set user ID
     *
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set user name
     *
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Get user type
     *
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set user type
     *
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
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
     * Get web services only
     *
     * @return bool
     */
    public function isWebServicesOnly()
    {
        return $this->webServicesOnly;
    }

    /**
     * Set web services only
     *
     * @param bool $webServicesOnly
     */
    public function setWebServicesOnly($webServicesOnly)
    {
        $this->webServicesOnly = $webServicesOnly;
    }

    /**
     * @return string[]
     */
    public function getRestrictedEntities()
    {
        return $this->restrictedEntities;
    }

    /**
     * @param string[] $restrictedEntities
     */
    public function setRestrictedEntities($restrictedEntities)
    {
        $this->restrictedEntities = $restrictedEntities;
    }

    /**
     * @return string[]
     */
    public function getRestrictedDepartments()
    {
        return $this->restrictedDepartments;
    }

    /**
     * @param string[] $restrictedDepartments
     */
    public function setRestrictedDepartments($restrictedDepartments)
    {
        $this->restrictedDepartments = $restrictedDepartments;
    }

    /**
     * Get single sign on enabled
     *
     * @return bool
     */
    public function isSsoEnabled()
    {
        return $this->ssoEnabled;
    }

    /**
     * Set single sign on enabled
     *
     * @param bool $ssoEnabled
     */
    public function setSsoEnabled($ssoEnabled)
    {
        $this->ssoEnabled = $ssoEnabled;
    }

    /**
     * Get single sign on federated user ID
     *
     * @return string
     */
    public function getSsoFederatedUserId()
    {
        return $this->ssoFederatedUserId;
    }

    /**
     * Set single sign on federated user ID
     *
     * @param string $ssoFederatedUserId
     */
    public function setSsoFederatedUserId($ssoFederatedUserId)
    {
        $this->ssoFederatedUserId = $ssoFederatedUserId;
    }
}
