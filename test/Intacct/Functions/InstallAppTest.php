<?php
/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct\Functions;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class InstallAppTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\InstallApp::__construct
     * @covers Intacct\Functions\InstallApp::setControlId
     * @covers Intacct\Functions\InstallApp::getControlId
     * @covers Intacct\Functions\InstallApp::setXmlFilename
     * @covers Intacct\Functions\InstallApp::getXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <installApp>
        <appxml/>
    </installApp>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $installApp = new InstallApp([
            'control_id' => 'unittest',
            'xml_filename' => realpath(getcwd() . '\test\Intacct\Functions\sample.xml'),
        ]);
        $installApp->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\InstallApp::__construct
     * @covers Intacct\Functions\InstallApp::setXmlFilename
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required xml_filename is missing
     */
    public function testNoFilename()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new InstallApp([
        ]);
    }

    /**
     * @covers Intacct\Functions\InstallApp::__construct
     * @covers Intacct\Functions\InstallApp::setXmlFilename
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage xml_filename is not readable
     */
    public function testNonexistentFilename()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        new InstallApp([
            'xml_filename' => getcwd() . '\test\Intacct\Functions\doesntexist.xml',
        ]);
    }
}