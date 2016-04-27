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

namespace Intacct\Tests\Xml;

use Intacct\Xml\AbstractResponse;
use Exception;


class AbstractResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractResponse
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage XML could not be parsed properly
     */
    public function testConstructInvalidXml()
    {
        $xml = '<bad></xml>';

        $args = [
            $xml,
        ];
        $this->getMockForAbstractClass('Intacct\Xml\AbstractResponse', $args);
    }

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Response is missing control block
     */
    public function testConstructMissingControlBlock()
    {
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

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @covers Intacct\Xml\ResponseException::__construct
     * @expectedException \Intacct\Xml\ResponseException
     * @expectedExceptionMessage Response control status failure
     */
    public function testConstructControlFailure()
    {
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

    /**
     * @covers Intacct\Xml\AbstractResponse::__construct
     * @covers Intacct\Xml\AbstractResponse::setControl
     * @covers Intacct\Xml\AbstractResponse::getControl
     */
    public function testGetControl()
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
