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

namespace Intacct;

use InvalidArgumentException;

class EndpointTest extends \PHPUnit_Framework_TestCase
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
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::__toString
     * @covers Intacct\Endpoint::getEndpoint
     * @covers Intacct\Endpoint::getVerifySSL
     */
    public function testDefaultEndpoint()
    {
        $endpoint = new Endpoint();
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
        $this->assertEquals(true, $endpoint->getVerifySSL());
    }
    
    /**
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::__toString
     * @covers Intacct\Endpoint::getEndpoint
     * @covers Intacct\Endpoint::getVerifySSL
     */
    public function testEnvEndpoint()
    {
        putenv('INTACCT_ENDPOINT_URL=https://envunittest.intacct.com/ia/xml/xmlgw.phtml');
        
        $endpoint = new Endpoint();
        $this->assertEquals('https://envunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertEquals('https://envunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
        $this->assertEquals(true, $endpoint->getVerifySSL());
        
        putenv('INTACCT_ENDPOINT_URL');
    }
    
    /**
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::__toString
     * @covers Intacct\Endpoint::setEndpoint
     * @covers Intacct\Endpoint::setVerifySSL
     * @covers Intacct\Endpoint::getVerifySSL
     */
    public function testArrayEndpoint()
    {
        $config = [
            'endpoint_url' => 'https://arrayunittest.intacct.com/ia/xml/xmlgw.phtml',
            'verify_ssl' => false,
        ];
        
        $endpoint = new Endpoint($config);
        $this->assertEquals('https://arrayunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
        $this->assertEquals('https://arrayunittest.intacct.com/ia/xml/xmlgw.phtml', $endpoint->getEndpoint());
        $this->assertEquals(false, $endpoint->getVerifySSL());
    }
    
    /**
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::__toString
     * @covers Intacct\Endpoint::setEndpoint
     */
    public function testNullEndpoint()
    {
        $config = [
            'endpoint_url' => null,
        ];
        
        $endpoint = new Endpoint($config);
        $this->assertEquals('https://api.intacct.com/ia/xml/xmlgw.phtml', $endpoint);
    }
    
    /**
     * @covers Intacct\Endpoint::setEndpoint
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage endpoint_url is not a valid string.
     */
    public function testNotStringUrlEndpoint()
    {
        $config = [
            'endpoint_url' => [ 'an array' ],
        ];
        
        new Endpoint($config);
    }
    
    /**
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::setEndpoint
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage endpoint_url is not a valid URL.
     */
    public function testInvalidUrlEndpoint()
    {
        $config = [
            'endpoint_url' => 'invalidurl',
        ];
        
        new Endpoint($config);
    }
    
    /**
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::setEndpoint
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage endpoint_url is not a valid URL.
     */
    public function testInvalidIntacctUrlEndpoint()
    {
        $config = [
            'endpoint_url' => 'endpoint_url is not a valid intacct.com domain name.',
        ];
        
        new Endpoint($config);
    }
    
    /**
     * @covers Intacct\Endpoint::__construct
     * @covers Intacct\Endpoint::setVerifySSL
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage verify_ssl is not a valid boolean type
     */
    public function testInvalidBoolVerifySsl()
    {
        $config = [
            'verify_ssl' => 0,
        ];
        
        new Endpoint($config);
    }
}
