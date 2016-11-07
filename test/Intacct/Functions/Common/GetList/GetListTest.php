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

namespace Intacct\Functions\Common\GetList;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class GetListTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Common\GetList\GetList::writeXml
     */
    public function testDefaultConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <get_list object="smarteventlog" showprivate="false" />
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new GetList('unittest');
        $exp->setObjectName('smarteventlog');

        $exp->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Common\GetList\GetList::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object Name is required for get_list
     */
    public function testNoFieldName()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $exp = new GetList();

        $exp->writeXml($xml);
    }
}
