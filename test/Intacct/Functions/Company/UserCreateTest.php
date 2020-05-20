<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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
 * @coversDefaultClass \Intacct\Functions\Company\UserCreate
 */
class UserCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <USERINFO>
            <LOGINID>U1234</LOGINID>
            <USERTYPE>business user</USERTYPE>
            <CONTACTINFO>
                <LASTNAME>Last</LASTNAME>
                <FIRSTNAME>First</FIRSTNAME>
                <EMAIL1>noreply@intacct.com</EMAIL1>
            </CONTACTINFO>
        </USERINFO>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        $record->setUserId('U1234');
        $record->setUserType(UserCreate::USER_TYPE_BUSINESS);
        $record->setLastName('Last');
        $record->setFirstName('First');
        $record->setPrimaryEmailAddress('noreply@intacct.com');

        $record->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage User ID is required for create
     */
    public function testRequiredUserId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        //$record->setUserId('U1234');
        $record->setUserType(UserCreate::USER_TYPE_BUSINESS);
        $record->setLastName('Last');
        $record->setFirstName('First');
        $record->setPrimaryEmailAddress('noreply@intacct.com');

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage User Type is required for create
     */
    public function testRequiredUserType()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        $record->setUserId('U1234');
        //$record->setUserType(UserCreate::USER_TYPE_BUSINESS);
        $record->setLastName('Last');
        $record->setFirstName('First');
        $record->setPrimaryEmailAddress('noreply@intacct.com');

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Last Name, First Name, and Primary Email, or an existing Contact Name, are required for create
     */
    public function testRequiredContactInfo()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        $record->setUserId('U1234');
        $record->setUserType(UserCreate::USER_TYPE_BUSINESS);
        //$record->setLastName('Last');
        //$record->setFirstName('First');
        //$record->setPrimaryEmailAddress('noreply@intacct.com');

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Last Name, First Name, and Primary Email, or an existing Contact Name, are required for create
     */
    public function testRequiredContactEmail()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        $record->setUserId('U1234');
        $record->setUserType(UserCreate::USER_TYPE_BUSINESS);
        $record->setLastName('Last');
        $record->setFirstName('First');
        //$record->setPrimaryEmailAddress('noreply@intacct.com');

        $record->writeXml($xml);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Primary Email Address is not a valid email
     */
    public function testValidContactEmail()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        $record->setPrimaryEmailAddress('this is not a valid email');

        $record->writeXml($xml);
    }

    /**
     */
    public function testRestrictions()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <USERINFO>
            <LOGINID>U1234</LOGINID>
            <USERTYPE>business user</USERTYPE>
            <CONTACTINFO>
                <LASTNAME>Last</LASTNAME>
                <FIRSTNAME>First</FIRSTNAME>
                <EMAIL1>noreply@intacct.com</EMAIL1>
            </CONTACTINFO>
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
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $record = new UserCreate('unittest');
        $record->setUserId('U1234');
        $record->setUserType(UserCreate::USER_TYPE_BUSINESS);
        $record->setLastName('Last');
        $record->setFirstName('First');
        $record->setPrimaryEmailAddress('noreply@intacct.com');
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
