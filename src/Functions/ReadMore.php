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

class ReadMore implements FunctionInterface
{
    
    use ControlIdTrait;
    
    /**
     *
     * @var string
     */
    private $resultId;
    
    /**
     * 
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'result_id' => null,
        ];
        $config = array_merge($defaults, $params);
        // TODO: Do we need to also check for object, view, or reportId?
        if (!$config['result_id']) {
            throw new InvalidArgumentException(
                'Required "result_id" key not supplied in params'
            );
        }
        
        $this->setControlId($config['control_id']);
        $this->resultId = $config['result_id'];
    }
    
    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('readMore');
        
        $xml->writeElement('resultId', $this->resultId, true);
        
        $xml->endElement(); //readMore
        
        $xml->endElement(); //function
    }
    
}
