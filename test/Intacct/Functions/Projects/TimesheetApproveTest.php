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

/**
 * @coversDefaultClass \Intacct\Functions\Projects\TimesheetApprove
 */
class TimesheetApproveTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <approve>
        <TIMESHEET>
            <RECORDNO>2</RECORDNO>
            <ENTRYKEYS>497,323</ENTRYKEYS>
            <APPROVEDBY>John</APPROVEDBY>
            <COMMENT>Approved by John</COMMENT>
        </TIMESHEET>
    </approve>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $classObj = new TimesheetApprove('unittest');
        $classObj->setRecordNo('2');
        $classObj->setApprovedBy('John');
        $classObj->setComment('Approved by John');
        $classObj->setLineRecordNo([497,323]);

        $classObj->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}