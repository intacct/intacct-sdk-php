<?php

namespace Intacct\Xml\Response\Operation;

use Intacct\Xml\SynchronousResponse;

class ResultTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Result
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
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>readByQuery</function>
                  <controlid>testControlId</controlid>
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
        $operation = $response->getOperation();
        $results = $operation->getResults();
        $this->object = $results[0];
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Result::__construct
     */
    public function testConstruct()
    {
        $this->assertThat($this->object, $this->isInstanceOf('Intacct\Xml\Response\Operation\Result'));
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Result::getStatus
     */
    public function testGetStatus()
    {
        $this->assertEquals('success', $this->object->getStatus());
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Result::getFunction
     */
    public function testGetFunction()
    {
        $this->assertEquals('readByQuery', $this->object->getFunction());
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Result::getControlId
     */
    public function testGetControlId()
    {
        $this->assertEquals('testControlId', $this->object->getControlId());
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Result::getData
     */
    public function testGetData()
    {
        $this->assertThat($this->object->getData(), $this->isInstanceOf('SimpleXMLIterator'));
    }

    /**
     * @covers Intacct\Xml\Response\Operation\Result::__construct
     * @covers Intacct\Xml\Response\Operation\Result::getErrors
     */
    public function testGetErrors()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-25T11:07:22-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>failure</status>
                  <function>readByQuery</function>
                  <controlid>testControlId</controlid>
                  <errormessage>
                        <error>
                              <errorno>Query Failed</errorno>
                              <description></description>
                              <description2>Object definition BADOBJECT not found</description2>
                              <correction></correction>
                        </error>
                  </errormessage>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
        $operation = $response->getOperation();
        $results = $operation->getResults();
        $result = $results[0];
        
        $this->assertEquals('failure', $result->getStatus());
        $this->assertInternalType('array', $result->getErrors());
        
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Result::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing status element
     */
    public function testMissingStatusElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <!--<status>success</status>-->
                  <function>readByQuery</function>
                  <controlid>testControlId</controlid>
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Result::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing function element
     */
    public function testMissingFunctionElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <!--<function>readByQuery</function>-->
                  <controlid>testControlId</controlid>
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
    }
    
    /**
     * @covers Intacct\Xml\Response\Operation\Result::__construct
     * @expectedException Exception
     * @expectedExceptionMessage Result block is missing controlid element
     */
    public function testMissingControlIdElement()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>intacct_dev</senderid>
            <controlid>ControlIdHere</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>fakeuser</userid>
                  <companyid>fakecompany</companyid>
                  <sessiontimestamp>2015-10-25T10:08:34-07:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>readByQuery</function>
                  <!--<controlid>testControlId</controlid>-->
                  <data listtype="department" count="0" totalcount="0" numremaining="0" resultId=""/>
            </result>
      </operation>
</response>
EOF;
        $response = new SynchronousResponse($xml);
    }

}
