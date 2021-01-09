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
 * @coversDefaultClass \Intacct\Xml\Response\ErrorMessage
 */
class ErrorMessageTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var ErrorMessage
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
<errormessage>
    <error>
          <errorno>1234</errorno>
          <description>description</description>
          <description2>Object definition &#39;BADOBJECT&#39; not found.</description2>
          <correction>strip&lt;out&gt;these&lt;/out&gt;tags.</correction>
    </error>
    <error>
          <errorno>5678</errorno>
          <description>strip&lt;out&gt;these&lt;/out&gt;tags.</description>
          <description2>Object definition &#39;BADOBJECT&#39; not found.</description2>
          <correction>correct.</correction>
    </error>
</errormessage>
EOF;
        $errorMessage = simplexml_load_string($xml, 'SimpleXMLIterator');
        $this->object = new ErrorMessage($errorMessage);
    }

    public function testGetErrors(): void
    {
        $errors = $this->object->getErrors();
        $this->assertIsArray($errors);
        $this->assertEquals('1234 description Object definition \'BADOBJECT\' not found. stripthesetags.', $errors[0]);
        $this->assertEquals('5678 stripthesetags. Object definition \'BADOBJECT\' not found. correct.', $errors[1]);
    }
}
