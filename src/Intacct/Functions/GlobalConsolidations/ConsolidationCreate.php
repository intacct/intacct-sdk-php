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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ConsolidationCreate extends AbstractConsolidation
{

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('consolidate');

        if (!$this->getReportingBookId()) {
            throw new InvalidArgumentException('Reporting Book ID is required to create consolidation');
        }
        $xml->writeElement('bookid', $this->getReportingBookId(), true);

        if (!$this->getReportingPeriodName()) {
            throw new InvalidArgumentException('Reporting Period Name is required to create consolidation');
        }
        $xml->writeElement('reportingperiodname', $this->getReportingPeriodName(), true);

        if ($this->processOffline === true) {
            $xml->writeElement('offline', 'T');
        } elseif ($this->processOffline === false) {
            $xml->writeElement('offline', 'F');
        }

        $xml->writeElement('updatesucceedingperiods', $this->isUpdateSucceedingPeriods());
        $xml->writeElement('changesonly', $this->isChangesOnly());
        $xml->writeElement('email', $this->getNotificationEmail());

        if (count($this->getEntities()) > 0) {
            $xml->startElement('entities');

            foreach ($this->getEntities() as $entity) {
                $entity->writeXml($xml);
            }

            $xml->endElement(); //entities
        }

        $xml->endElement(); //consolidate

        $xml->endElement(); //function
    }
}
