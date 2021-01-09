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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Create a new task record
 */
class TaskCreate extends AbstractTask
{

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

        $xml->writeElementDate('PBEGINDATE', $this->getPlannedBeginDate());
        $xml->writeElementDate('PENDDATE', $this->getPlannedEndDate());
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
