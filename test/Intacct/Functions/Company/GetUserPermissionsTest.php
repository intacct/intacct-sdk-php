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

namespace Intacct\Functions\Company;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class GetUserPermissionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\Company\GetUserPermissions::__construct
     * @covers Intacct\Functions\Company\GetUserPermissions::setControlId
     * @covers Intacct\Functions\Company\GetUserPermissions::getControlId
     * @covers Intacct\Functions\Company\GetUserPermissions::writeXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <getUserPermissions>
        <userId>U2398598234</userId>
    </getUserPermissions>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $userPermissions = new GetUserPermissions([
            'user_id' => 'U2398598234',
            'control_id' => 'unittest',
        ]);
        $userPermissions->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Company\GetUserPermissions::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "user_id" key not supplied in params
     */
    public function testNoUserId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new GetUserPermissions([
        ]);
    }
}
