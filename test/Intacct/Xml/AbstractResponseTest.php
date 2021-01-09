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

namespace Intacct\Xml;

/**
 * @coversDefaultClass \Intacct\Xml\AbstractResponse
 */
class AbstractResponseTest extends \PHPUnit\Framework\TestCase
{

    public function testConstructInvalidXml(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("XML could not be parsed properly");

        $xml = '<bad></xml>';

        $args = [
            $xml,
        ];
        $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    public function testConstructMissingControlBlock(): void
    {
        $this->expectException(\Intacct\Exception\IntacctException::class);
        $this->expectExceptionMessage("Response is missing control block");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <nocontrolblock/>
</response>
EOF;

        $args = [
            $xml,
        ];
        $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    public function testConstructControlFailure(): void
    {
        $this->expectException(\Intacct\Exception\ResponseException::class);
        $this->expectExceptionMessage("Response control status failure - XL03000006 test is not a valid transport policy.");

        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>failure</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <errormessage>
            <error>
                  <errorno>XL03000006</errorno>
                  <description></description>
                  <description2>test is not a valid transport policy.</description2>
                  <correction></correction>
            </error>
      </errormessage>
</response>
EOF;

        $args = [
            $xml,
        ];
        $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    public function testGetControl(): void
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
        $this->assertThat($stub, $this->isInstanceOf('Intacct\Xml\AbstractResponse'));
        $control = $stub->getControl();
        $this->assertThat($control, $this->isInstanceOf('Intacct\Xml\Response\Control'));
    }
}
