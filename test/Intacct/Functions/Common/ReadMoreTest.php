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

namespace Intacct\Functions\Common;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ReadMoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\Common\ReadMore::__construct
     * @covers Intacct\Functions\Common\ReadMore::setControlId
     * @covers Intacct\Functions\Common\ReadMore::writeXml
     */
    public function testParamOverrides()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <readMore>
        <resultId>6465763031VyprCMCoHYQAAGr@aRsAAAAU4</resultId>
    </readMore>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $readMore = new ReadMore([
            'result_id' => '6465763031VyprCMCoHYQAAGr@aRsAAAAU4',
            'control_id' => 'unittest',
        ]);
        $readMore->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }



    /**
     * @covers Intacct\Functions\Common\ReadMore::__construct
     * @covers Intacct\Functions\Common\ReadMore::setControlId
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "result_id" key not supplied in params
     */
    public function testNoResultId()
    {
        new ReadMore([
        ]);
    }
}
