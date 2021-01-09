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

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * @coversDefaultClass \Intacct\Functions\Company\UserUpdate
 */
class UserUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update>
        <USERINFO>
            <LOGINID>U1234</LOGINID>
        </USERINFO>
    </update>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserUpdate('unittest');
        $record->setUserId('U1234');

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredUserId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("User ID is required for update");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserUpdate('unittest');
        //$record->setUserId('U1234');

        $record->writeXml($xml);
    }

    public function testRestrictions(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <update>
        <USERINFO>
            <LOGINID>U1234</LOGINID>
            <USERLOCATIONS>
                <LOCATIONID>E100</LOCATIONID>
            </USERLOCATIONS>
            <USERLOCATIONS>
                <LOCATIONID>E200</LOCATIONID>
            </USERLOCATIONS>
            <USERDEPARTMENTS>
                <DEPARTMENTID>D100</DEPARTMENTID>
            </USERDEPARTMENTS>
            <USERDEPARTMENTS>
                <DEPARTMENTID>D200</DEPARTMENTID>
            </USERDEPARTMENTS>
        </USERINFO>
    </update>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserUpdate('unittest');
        $record->setUserId('U1234');
        $record->setRestrictedEntities([
            'E100',
            'E200',
        ]);
        $record->setRestrictedDepartments([
            'D100',
            'D200',
        ]);


        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }
}
