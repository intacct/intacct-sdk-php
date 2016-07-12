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

namespace Intacct\Functions;

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class InstallApp implements FunctionInterface
{

    use ControlIdTrait;
    
    /**
     *
     * @var string
     */
    private $xmlFilename;

    /**
     *
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'xml_filename' => null,
        ];
        $config = array_merge($defaults, $params);
        
        $this->setControlId($config['control_id']);
        $this->setXmlFilename($config['xml_filename']);
    }
    
    private function setXmlFilename($xmlFilename)
    {
        if (!$xmlFilename) {
            throw new InvalidArgumentException(
                'Required xml_filename is missing'
            );
        }
        if (!is_readable($xmlFilename)) {
            throw new InvalidArgumentException(
                'xml_filename is not readable'
            );
        }
        
        $this->xmlFilename = $xmlFilename;
    }
    
    /**
     *
     * @param XMLWriter $xml
     * @throws InvalidArgumentException
     * @todo Validate the app.xml is actually a platform app?
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('installApp');
        $xml->startElement('appxml');
        
        if (!is_readable($this->xmlFilename)) {
            throw new InvalidArgumentException(
                'xml_filename is not readable for installApp'
            );
        }
        $xml->writeCdata(file_get_contents($this->xmlFilename));
        
        $xml->endElement(); //appxml
        $xml->endElement(); //installApp
        
        $xml->endElement(); //function
    }
}
