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

/**
 * @coversDefaultClass \Intacct\Functions\GlobalConsolidations\ConsolidationCreate
 */
class ConsolidationCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testDefaultParams(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <consolidate>
        <bookid>USD Books</bookid>
        <reportingperiodname>Month Ended June 2016</reportingperiodname>
    </consolidate>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $rate = new ConsolidationCreate('unittest');
        $rate->setReportingBookId('USD Books');
        $rate->setReportingPeriodName('Month Ended June 2016');

        $rate->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testFull(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <consolidate>
        <bookid>USD Books</bookid>
        <reportingperiodname>Month Ended June 2016</reportingperiodname>
        <offline>T</offline>
        <updatesucceedingperiods>false</updatesucceedingperiods>
        <changesonly>true</changesonly>
        <email>noreply@intacct.com</email>
        <entities>
            <csnentity>
                <entityid>VT</entityid>
                <bsrate>0.0000483500</bsrate>
                <warate>0.0000485851</warate>
            </csnentity>
        </entities>
    </consolidate>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $rate = new ConsolidationCreate('unittest');
        $rate->setReportingBookId('USD Books');
        $rate->setReportingPeriodName('Month Ended June 2016');
        $rate->setProcessOffline(true);
        $rate->setChangesOnly(true);
        $rate->setUpdateSucceedingPeriods(false);
        $rate->setNotificationEmail('noreply@intacct.com');

        $entity1 = new ConsolidationEntity();
        $entity1->setEntityId('VT');
        $entity1->setEndingSpotRate(0.0000483500);
        $entity1->setWeightedAverageRate(0.0000485851);

        $rate->setEntities([
            $entity1,
        ]);

        $rate->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
