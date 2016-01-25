<?php

namespace Intacct\Xml\Request\Operation;

use Intacct\Xml\Request\Operation\Content\GetAPISession;

class ContentTest extends \PHPUnit_Framework_TestCase
{

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
     * @covers Intacct\Xml\Request\Operation\Content::__construct
     */
    public function testContent()
    {
        $content = new Content();
        $func = new GetAPISession();
        $content->append($func);
    }

}
