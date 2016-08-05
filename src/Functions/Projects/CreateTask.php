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

namespace Intacct\Functions\Projects;

use Intacct\Fields\Date;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class CreateTask extends AbstractTask
{

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
     * @return Date
     */
    public function getPlannedBeginDate()
    {
        return $this->plannedBeginDate;
    }

    /**
     * @param Date $plannedBeginDate
     */
    public function setPlannedBeginDate($plannedBeginDate)
    {
        $this->plannedBeginDate = $plannedBeginDate;
    }

    /**
     * @return Date
     */
    public function getPlannedEndDate()
    {
        return $this->plannedEndDate;
    }

    /**
     * @param Date $plannedEndDate
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
     * @return boolean
     */
    public function isBillable()
    {
        return $this->billable;
    }

    /**
     * @param boolean $billable
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
     * @return boolean
     */
    public function isMilestone()
    {
        return $this->milestone;
    }

    /**
     * @param boolean $milestone
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * @return boolean
     */
    public function isUtilized()
    {
        return $this->utilized;
    }

    /**
     * @param boolean $utilized
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

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'task_name' => null,
            'project_id' => null,
            'planned_begin_date' => null,
            'planned_end_date' => null,
            'class_id' => null,
            'item_id' => null,
            'billable' => null,
            'description' => null,
            'milestone' => null,
            'utilized' => null,
            'priority' => null,
            'wbs_code' => null,
            'task_status' => null,
            'time_type' => null,
            'parent_task_record_no' => null,
            'attachments_id' => null,
            'observed_percent_completed' => null,
            'planned_duration' => null,
            'estimated_duration' => null,
            'custom_fields' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->setTaskName($config['task_name']);
        $this->setProjectId($config['project_id']);
        $this->setPlannedBeginDate($config['planned_begin_date']);
        $this->setPlannedEndDate($config['planned_end_date']);
        $this->setClassId($config['class_id']);
        $this->setItemId($config['item_id']);
        $this->setBillable($config['billable']);
        $this->setDescription($config['description']);
        $this->setMilestone($config['milestone']);
        $this->setUtilized($config['utilized']);
        $this->setPriority($config['priority']);
        $this->setWbsCode($config['wbs_code']);
        $this->setTaskStatus($config['task_status']);
        $this->setTimeType($config['time_type']);
        $this->setParentTaskRecordNo($config['parent_task_record_no']);
        $this->setAttachmentsId($config['attachments_id']);
        $this->setObservedPercentCompleted($config['observed_percent_completed']);
        $this->setPlannedDuration($config['planned_duration']);
        $this->setEstimatedDuration($config['estimated_duration']);

        $this->setCustomFields($config['custom_fields']);
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('create');
        $xml->startElement('TASK');

        if (!$this->getTaskName()) {
            throw new InvalidArgumentException('Task Name is required for create');
        }
        $xml->writeElement('NAME', $this->getTaskName(), true);
        if (!$this->getProjectId()) {
            throw new InvalidArgumentException('Project ID is required for create');
        }
        $xml->writeElement('PROJECTID', $this->getProjectId(), true);

        $xml->writeElement('PBEGINDATE', $this->getPlannedBeginDate());
        $xml->writeElement('PENDDATE', $this->getPlannedEndDate());
        $xml->writeElement('CLASSID', $this->getClassId());
        $xml->writeElement('ITEMID', $this->getItemId());
        $xml->writeElement('BILLABLE', $this->isBillable());
        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('ISMILESTONE', $this->isMilestone());
        $xml->writeElement('UTILIZED', $this->isUtilized());
        $xml->writeElement('PRIORITY', $this->getPriority());
        $xml->writeElement('TASKNO', $this->getWbsCode());
        $xml->writeElement('TASKSTATUS', $this->getTaskStatus());
        $xml->writeElement('TIMETYPENAME', $this->getTimeType());
        $xml->writeElement('PARENTKEY', $this->getParentTaskRecordNo());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('OBSPERCENTCOMPLETE', $this->getObservedPercentCompleted());
        $xml->writeElement('BUDGETQTY', $this->getPlannedDuration());
        $xml->writeElement('ESTQTY', $this->getEstimatedDuration());

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //TASK
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
