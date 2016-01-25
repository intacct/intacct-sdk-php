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

namespace Intacct\Xml\Request\Operation\Content;

use ArrayIterator;
use DateTime;
use DOMElement;
use DOMException;
use InvalidArgumentException;
use XMLWriter;

trait XMLHelperTrait
{

    /**
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
     * 
     * @param ArrayIterator $array
     * @param XMLWriter $xml
     */
    protected function recursiveGetXml(ArrayIterator $array, XMLWriter &$xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $xml->startElement($key);
                $this->recursiveGetXml($value, $xml);
                $xml->endElement();
            } else {
                $xml->writeElement($key, $value);
            }
        }
    }
    
    /**
     * 
     * @param DateTime $date
     * @param XMLWriter $xml
     */
    protected function dateSplitToXml(DateTime $date, XMLWriter &$xml)
    {
        list($year, $month, $day) = split('-', $date->format('Y-m-d'));
        
        $xml->writeElement('year', $year);
        $xml->writeElement('month', $month);
        $xml->writeElement('day', $day);
    }

}
