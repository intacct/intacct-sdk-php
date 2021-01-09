<?php
/**
 * Copyright 2021 Sage Intacct, Inc.
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

namespace Intacct\Xml\Response;

/**
 * @coversDefaultClass \Intacct\Xml\Response\Control
 */
class ControlTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Control
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp(): void
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;

        $args = [
            $xml,
        ];
        $stub = $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);

        $this->object = $stub->getControl();
    }

    public function testGetStatus(): void
    {
        $this->assertEquals('success', $this->object->getStatus());
    }

    public function testGetSenderId(): void
    {
        $this->assertEquals('testsenderid', $this->object->getSenderId());
    }

    public function testGetControlId(): void
    {
        $this->assertEquals('ControlIdHere', $this->object->getControlId());
    }

    public function testGetUniqueId(): void
    {
        $this->assertEquals('false', $this->object->getUniqueId());
    }

    public function testGetDtdVersion(): void
    {
        $this->assertEquals('3.0', $this->object->getDtdVersion());
    }

    public function testMissingStatusElement(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Control block is missing status element");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control/>
</response>
EOF;

        $args = [
            $xml,
        ];
        $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }
}
