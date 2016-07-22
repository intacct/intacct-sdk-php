<?php

/*
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

namespace Intacct\Xml\Request;

use ArrayIterator;
use DOMElement;
use DOMException;
use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

trait XMLHelperTrait
{

    /**
     * Get if name is valid for use as an XML element
     *
     * @param string $name
     * @return boolean
     */
    protected function isValidXmlName($name)
    {
        try {
            new DOMElement($name);
            return true;
        } catch (DOMException $ex) {
            return false;
        }
    }
    
    /**
     * Check array keys if valid for use as XML elements
     *
     * @param array $array
     * @throws InvalidArgumentException
     */
    protected function checkFieldKeysAreValidXml(array $array)
    {
        foreach ($array as $key => $value) {
            if ($this->isValidXmlName($key) === false) {
                throw new InvalidArgumentException(
                    'field name "' . $key . '" is not a valid name for an XML element'
                );
            }
            if (is_array($value)) {
                $this->checkFieldKeysAreValidXml($value);
            }
        }
    }
    
    /**
     * Recurse through array and write XML
     *
     * @param array|ArrayIterator $array
     * @param XMLWriter $xml
     */
    protected function recursiveGetXml($array, XMLWriter &$xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $xml->startElement($key);
                $this->recursiveGetXml($value, $xml);
                $xml->endElement();
            } else {
                $xml->writeElement($key, $value, true);
            }
        }
    }
}
