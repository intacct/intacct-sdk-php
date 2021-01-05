<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

namespace Intacct\Functions\PlatformServices;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

/**
 * Install a new, or update an existing, platform application
 */
class ApplicationInstall extends AbstractFunction
{
    
    /** @var string */
    private $xmlFilename;

    /**
     * @return string
     */
    public function getXmlFilename()
    {
        return $this->xmlFilename;
    }
    
    /**
     * @param string $xmlFilename
     * @throws InvalidArgumentException
     */
    public function setXmlFilename($xmlFilename)
    {
        if (!is_readable($xmlFilename)) {
            throw new InvalidArgumentException(
                'XML Filename is not readable'
            );
        }
        
        $this->xmlFilename = $xmlFilename;
    }
    
    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throws InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('installApp');
        $xml->startElement('appxml');

        if (!$this->getXmlFilename()) {
            throw new InvalidArgumentException('XML Filename is required for install');
        }
        if (!is_readable($this->getXmlFilename())) {
            throw new InvalidArgumentException(
                'XML Filename is not readable for install'
            );
        }
        $xml->writeCdata(file_get_contents($this->getXmlFilename()));
        
        $xml->endElement(); //appxml
        $xml->endElement(); //installApp
        
        $xml->endElement(); //function
    }
}
