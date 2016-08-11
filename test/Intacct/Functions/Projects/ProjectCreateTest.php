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

namespace Intacct\Functions\Projects;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class ProjectCreateTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Intacct\Functions\Projects\ProjectCreate::writeXml
     */
    public function testConstruct()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <create>
        <PROJECT>
            <PROJECTID>P1234</PROJECTID>
            <NAME>hello world</NAME>
            <PROJECTCATEGORY>Contract</PROJECTCATEGORY>
        </PROJECT>
    </create>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $project = new ProjectCreate('unittest');
        $project->setProjectId('P1234');
        $project->setProjectName('hello world');
        $project->setProjectCategory('Contract');

        $project->writeXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\Projects\ProjectCreate::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Project ID is required for create
     */
    public function testRequiredProjectId()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $project = new ProjectCreate('unittest');
        //$project->setProjectId('P1234');
        //$project->setProjectName('hello world');
        //$project->setProjectCategory('Contract');

        $project->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\Projects\ProjectCreate::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Project Name is required for create
     */
    public function testRequiredProjectName()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $project = new ProjectCreate('unittest');
        $project->setProjectId('P1234');
        //$project->setProjectName('hello world');
        //$project->setProjectCategory('Contract');

        $project->writeXml($xml);
    }

    /**
     * @covers Intacct\Functions\Projects\ProjectCreate::writeXml
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Project Category is required for create
     */
    public function testRequiredProjectCategory()
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $project = new ProjectCreate('unittest');
        $project->setProjectId('P1234');
        $project->setProjectName('hello world');
        //$project->setProjectCategory('Contract');

        $project->writeXml($xml);
    }
}
