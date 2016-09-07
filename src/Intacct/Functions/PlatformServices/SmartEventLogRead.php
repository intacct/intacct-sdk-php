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

namespace Intacct\Functions\PlatformServices;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class SmartEventLogRead extends AbstractFunction
{

    /** @var int */
    private $maxTotalCount = 10000;

    /** @var bool */
    private $showPrivate = false;

    /**
     * @return int
     */
    public function getMaxTotalCount()
    {
        return $this->maxTotalCount;
    }

    /**
     * @param int $maxTotalCount
     */
    public function setMaxTotalCount($maxTotalCount)
    {
        $this->maxTotalCount = $maxTotalCount;
    }

    /**
     * @return boolean
     */
    public function isShowPrivate()
    {
        return $this->showPrivate;
    }

    /**
     * @param boolean $showPrivate
     */
    public function setShowPrivate($showPrivate)
    {
        $this->showPrivate = $showPrivate;
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

        $xml->startElement('get_list');
        $xml->writeAttribute('object', 'smarteventlog');
        $xml->writeAttribute('maxitems', 10000);
        $xml->writeAttribute('showprivate', false);

        if (!$this->getEmployeeId()) {
            throw new InvalidArgumentException('Employee ID is required for create');
        }
        $xml->writeElement('EMPLOYEEID', $this->getEmployeeId(), true);
        if (!$this->getBeginDate()) {
            throw new InvalidArgumentException('Begin Date is required for create');
        }
        $xml->writeElement('BEGINDATE', $this->getBeginDate(), true);

        $xml->writeElement('DESCRIPTION', $this->getDescription());
        $xml->writeElement('SUPDOCID', $this->getAttachmentsId());
        $xml->writeElement('STATE', $this->getAction());

        $xml->startElement('TIMESHEETENTRIES');
        if (count($this->getEntries()) > 0) {
            foreach ($this->getEntries() as $entry) {
                $entry->writeXml($xml);
            }
        } else {
            throw new InvalidArgumentException('Timesheet must have at least 1 entry');
        }
        $xml->endElement(); //TIMESHEETENTRIES

        $this->writeXmlImplicitCustomFields($xml);

        $xml->endElement(); //TIMESHEET
        $xml->endElement(); //create

        $xml->endElement(); //function
    }
}
