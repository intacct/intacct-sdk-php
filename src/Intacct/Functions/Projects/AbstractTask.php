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

namespace Intacct\Functions\Projects;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractTask extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var int|string */
    protected $recordNo;

    /** @var string */
    protected $taskName;

    /** @var string */
    protected $projectId;

    /** @var \DateTime */
    protected $plannedBeginDate;

    /** @var \DateTime */
    protected $plannedEndDate;

    /** @var string */
    protected $classId;

    /** @var string */
    protected $itemId;

    /** @var bool */
    protected $billable;

    /** @var string */
    protected $description;

    /** @var bool */
    protected $milestone;

    /** @var bool */
    protected $utilized;

    /** @var string */
    protected $priority;

    /** @var string */
    protected $wbsCode;

    /** @var string */
    protected $taskStatus;

    /** @var string */
    protected $timeType;

    /** @var int|string */
    protected $parentTaskRecordNo;

    /** @var string */
    protected $attachmentsId;

    /** @var float|int|string */
    protected $observedPercentCompleted;

    /** @var float|int|string */
    protected $plannedDuration;

    /** @var float|int|string */
    protected $estimatedDuration;

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
    public function getTaskName()
    {
        return $this->taskName;
    }

    /**
     * @param string $taskName
     */
    public function setTaskName($taskName)
    {
        $this->taskName = $taskName;
    }

    /**
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return \DateTime
     */
    public function getPlannedBeginDate()
    {
        return $this->plannedBeginDate;
    }

    /**
     * @param \DateTime $plannedBeginDate
     */
    public function setPlannedBeginDate($plannedBeginDate)
    {
        $this->plannedBeginDate = $plannedBeginDate;
    }

    /**
     * @return \DateTime
     */
    public function getPlannedEndDate()
    {
        return $this->plannedEndDate;
    }

    /**
     * @param \DateTime $plannedEndDate
     */
    public function setPlannedEndDate($plannedEndDate)
    {
        $this->plannedEndDate = $plannedEndDate;
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
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return bool
     */
    public function isBillable()
    {
        return $this->billable;
    }

    /**
     * @param bool $billable
     */
    public function setBillable($billable)
    {
        $this->billable = $billable;
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
    public function isMilestone()
    {
        return $this->milestone;
    }

    /**
     * @param bool $milestone
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * @return bool
     */
    public function isUtilized()
    {
        return $this->utilized;
    }

    /**
     * @param bool $utilized
     */
    public function setUtilized($utilized)
    {
        $this->utilized = $utilized;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getWbsCode()
    {
        return $this->wbsCode;
    }

    /**
     * @param string $wbsCode
     */
    public function setWbsCode($wbsCode)
    {
        $this->wbsCode = $wbsCode;
    }

    /**
     * @return string
     */
    public function getTaskStatus()
    {
        return $this->taskStatus;
    }

    /**
     * @param string $taskStatus
     */
    public function setTaskStatus($taskStatus)
    {
        $this->taskStatus = $taskStatus;
    }

    /**
     * @return string
     */
    public function getTimeType()
    {
        return $this->timeType;
    }

    /**
     * @param string $timeType
     */
    public function setTimeType($timeType)
    {
        $this->timeType = $timeType;
    }

    /**
     * @return int|string
     */
    public function getParentTaskRecordNo()
    {
        return $this->parentTaskRecordNo;
    }

    /**
     * @param int|string $parentTaskRecordNo
     */
    public function setParentTaskRecordNo($parentTaskRecordNo)
    {
        $this->parentTaskRecordNo = $parentTaskRecordNo;
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
     * @return float|int|string
     */
    public function getObservedPercentCompleted()
    {
        return $this->observedPercentCompleted;
    }

    /**
     * @param float|int|string $observedPercentCompleted
     */
    public function setObservedPercentCompleted($observedPercentCompleted)
    {
        $this->observedPercentCompleted = $observedPercentCompleted;
    }

    /**
     * @return float|int|string
     */
    public function getPlannedDuration()
    {
        return $this->plannedDuration;
    }

    /**
     * @param float|int|string $plannedDuration
     */
    public function setPlannedDuration($plannedDuration)
    {
        $this->plannedDuration = $plannedDuration;
    }

    /**
     * @return float|int|string
     */
    public function getEstimatedDuration()
    {
        return $this->estimatedDuration;
    }

    /**
     * @param float|int|string $estimatedDuration
     */
    public function setEstimatedDuration($estimatedDuration)
    {
        $this->estimatedDuration = $estimatedDuration;
    }
}
