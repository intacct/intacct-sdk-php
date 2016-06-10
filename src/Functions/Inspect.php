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

class Inspect implements FunctionInterface
{

    use ControlIdTrait;
    use ObjectTrait;

    /**
     *
     * @var bool
     */
    private $showDetail;

    /**
     * 
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'show_detail' => false,
            'object' => null,
        ];
        $config = array_merge($defaults, $params);
        
        $this->setControlId($config['control_id']);
        $this->setShowDetail($config['show_detail']);
        $this->setObjectName($config['object']);
    }
    
    /**
     * 
     * @param bool $showDetail
     * @throws InvalidArgumentException
     */
    private function setShowDetail($showDetail)
    {
        if (!is_bool($showDetail)) {
            throw new InvalidArgumentException('show_detail not valid boolean type');
        }
        
        $this->showDetail = $showDetail;
    }
    
    /**
     * 
     * @return string
     */
    private function getShowDetail()
    {
        return $this->showDetail === true ? '1' : '0';
    }
    
    /**
     * 
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('inspect');
        $xml->writeAttribute('detail', $this->getShowDetail());
        
        $xml->writeElement('object', $this->getObjectName(), true);
        
        $xml->endElement(); //inspect
        
        $xml->endElement(); //function
    }

}
