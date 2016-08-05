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
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractTask extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $taskName;

    /** @var string */
    protected $projectId;

    /** @var Date */
    protected $plannedBeginDate;

    /** @var Date */
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

    /** @var int|string */
    protected $recordNo;
}
