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

namespace Intacct\Xml;

use Exception;

class AsynchronousResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AsynchronousResponse
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
     * @covers Intacct\Xml\AsynchronousResponse::__construct
     * @covers Intacct\Xml\AsynchronousResponse::setAcknowledgement
     * @covers Intacct\Xml\AsynchronousResponse::getAcknowledgement
     */
    public function testGetAcknowledgement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <acknowledgement>
            <status>success</status>
      </acknowledgement>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
</response>
EOF;
        $response = new AsynchronousResponse($xml);
        $acknowledgement = $response->getAcknowledgement();
        $this->assertThat($acknowledgement, $this->isInstanceOf('Intacct\Xml\Response\Acknowledgement'));
    }
    
    /**
     * @covers Intacct\Xml\AsynchronousResponse::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Response is missing acknowledgement block
     */
    public function testMissingAcknowledgementBlock()
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
        new AsynchronousResponse($xml);
    }
}
