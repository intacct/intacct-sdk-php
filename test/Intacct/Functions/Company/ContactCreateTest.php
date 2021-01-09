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
 * @coversDefaultClass \Intacct\Functions\Company\ContactCreate
 */
class ContactCreateTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct(): void
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <CONTACT>
            <CONTACTNAME>hello</CONTACTNAME>
            <PRINTAS>world</PRINTAS>
        </CONTACT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new ContactCreate('unittest');
        $obj->setContactName('hello');
        $obj->setPrintAs('world');

        $obj->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    public function testRequiredClassId(): void
    {
        $this->expectExceptionMessage("Contact Name is required for create");
        $this->expectException(InvalidArgumentException::class);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new ContactCreate('unittest');
        //$obj->setContactName('hello');
        //$obj->setPrintAs('world');

        $obj->writeXml($xml);
    }

    public function testRequiredClassName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Print As is required for create");

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $obj = new ContactCreate('unittest');
        $obj->setContactName('hello');
        //$obj->setPrintAs('world');

        $obj->writeXml($xml);
    }
}
