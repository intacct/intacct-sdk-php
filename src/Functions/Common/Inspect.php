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

namespace Intacct\Functions\Common;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Inspect extends AbstractFunction
{

    /** @var string */
    private $objectName;

    /** @var bool */
    private $showDetail;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var string $object Object name to query
     *      @var bool $show_detail Show object and field detail
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'show_detail' => false,
            'object' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->showDetail = $config['show_detail'];
        $this->objectName = $config['object'];
    }
    
    /**
     * Get show detail
     *
     * @return string
     */
    private function writeXmlShowDetail()
    {
        return $this->showDetail === true ? '1' : '0';
    }
    
    /**
     * Write the inspect block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('inspect');
        $xml->writeAttribute('detail', $this->writeXmlShowDetail());
        
        $xml->writeElement('object', $this->objectName, true);
        
        $xml->endElement(); //inspect
        
        $xml->endElement(); //function
    }
}
