<?php

namespace Intacct\Xml\Response;

class ErrorMessageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ErrorMessage
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<errormessage>
    <error>
          <errorno>1234</errorno>
          <description>description</description>
          <description2>Object definition BADOBJECT not found</description2>
          <correction>strip&lt;out&gt;these&lt;/out&gt;tags</correction>
    </error>
    <error>
          <errorno>5678</errorno>
          <description>strip&lt;out&gt;these&lt;/out&gt;tags</description>
          <description2>Object definition BADOBJECT not found</description2>
          <correction>correct</correction>
    </error>
</errormessage>
EOF;
        $errorMessage = simplexml_load_string($xml, 'SimpleXMLIterator');
        $this->object = new ErrorMessage($errorMessage);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Intacct\Xml\Response\ErrorMessage::__construct
     * @covers Intacct\Xml\Response\ErrorMessage::getErrors
     * @covers Intacct\Xml\Response\ErrorMessage::cleanse
     */
    public function testGetErrors()
    {
        $errors = $this->object->getErrors();
        $this->assertInternalType('array', $errors);
        $this->assertEquals('1234: description: Object definition BADOBJECT not found: stripthesetags', $errors[0]);
        $this->assertEquals('5678: stripthesetags: Object definition BADOBJECT not found: correct', $errors[1]);
    }

}
