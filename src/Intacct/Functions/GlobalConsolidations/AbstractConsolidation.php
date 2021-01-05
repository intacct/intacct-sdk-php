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

namespace Intacct\Functions\GlobalConsolidations;

use Intacct\Functions\AbstractFunction;
use InvalidArgumentException;

abstract class AbstractConsolidation extends AbstractFunction
{

    /** @var string */
    protected $reportingBookId;

    /** @var bool */
    protected $processOffline;

    /** @var bool */
    protected $updateSucceedingPeriods;

    /** @var bool */
    protected $changesOnly;

    /** @var string */
    protected $notificationEmail;

    /** @var string */
    protected $reportingPeriodName;

    /** @var ConsolidationEntity[] */
    protected $entities = [];

    /**
     * @return string
     */
    public function getReportingBookId()
    {
        return $this->reportingBookId;
    }

    /**
     * @param string $reportingBookId
     */
    public function setReportingBookId($reportingBookId)
    {
        $this->reportingBookId = $reportingBookId;
    }

    /**
     * @return bool
     */
    public function isProcessOffline()
    {
        return $this->processOffline;
    }

    /**
     * @param bool $processOffline
     */
    public function setProcessOffline($processOffline)
    {
        $this->processOffline = $processOffline;
    }

    /**
     * @return bool
     */
    public function isUpdateSucceedingPeriods()
    {
        return $this->updateSucceedingPeriods;
    }

    /**
     * @param bool $updateSucceedingPeriods
     */
    public function setUpdateSucceedingPeriods($updateSucceedingPeriods)
    {
        $this->updateSucceedingPeriods = $updateSucceedingPeriods;
    }

    /**
     * @return bool
     */
    public function isChangesOnly()
    {
        return $this->changesOnly;
    }

    /**
     * @param bool $changesOnly
     */
    public function setChangesOnly($changesOnly)
    {
        $this->changesOnly = $changesOnly;
    }

    /**
     * @return string
     */
    public function getNotificationEmail()
    {
        return $this->notificationEmail;
    }

    /**
     * @param string $notificationEmail
     */
    public function setNotificationEmail($notificationEmail)
    {
        if (filter_var($notificationEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Notification Email is not a valid email');
        }
        $this->notificationEmail = $notificationEmail;
    }

    /**
     * @return string
     */
    public function getReportingPeriodName()
    {
        return $this->reportingPeriodName;
    }

    /**
     * @param string $reportingPeriodName
     */
    public function setReportingPeriodName($reportingPeriodName)
    {
        $this->reportingPeriodName = $reportingPeriodName;
    }

    /**
     * @return ConsolidationEntity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param ConsolidationEntity[] $entities
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }
}
